<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Variation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function productList($paramOne = null, $paramTwo = null, $paramThree = null)
    {
        if ($paramThree) {
            return $this->handleProductVariant($paramTwo, $paramThree);
        }

        if ($paramOne) {
            return $this->handleProductListing($paramOne, $paramTwo);
        }
    }

    private function handleProductVariant($paramTwo, $paramThree)
    {

        preg_match('/(\d+)$/', $paramThree, $matches);

        if (preg_match('/\d+_\d+$/', $paramThree, $mat)) {
            $attributes = [];
            $variant = Variation::query()->with(['product.variations.priceVariants', 'albums', 'priceVariants', 'attributes.attributeValues'])->findOrFail($matches[1]);

            $variant->attributes->map(function ($attribute) use (&$attributes) {
                return $attributes[] = [
                    'attribute_name' => $attribute->name,
                    'attribute_value' => $attribute->attributeValues->find($attribute->pivot->attribute_value_id)->value
                ];
            });

            $product = $variant->product;

            $hasMatchingVariation =
                $product->name === $variant->name &&
                $product->slug === $variant->slug &&
                $product->image === $variant->image;

            $fakeProductPayed = Cache::remember('fake_product_payed', now()->addDay(), function () {
                return Product::query()->inRandomOrder()->with('brand', 'category')->where('status', 1)->limit(7)->get();
            });

            return view('frontend.pages.product.product-detail', compact('hasMatchingVariation', 'variant', 'product', 'attributes', 'fakeProductPayed'));
        }

        $product = Product::with(['variations' => function ($q) {
            $q->where('status', 1);
        }, 'variations.priceVariants'])
            ->withCount('variations')
            ->findOrFail($matches[1]);

        $unpublishedVariations = $product->variations()->where('status', 2)->get();
        $brand = Brand::where('slug', $paramTwo)->firstOrFail();
        $relatedProducts = $this->getRelatedProducts($brand, $product);

        return view('frontend.pages.product.product-variants', compact('product', 'relatedProducts', 'unpublishedVariations'));
    }

    private function getRelatedProducts($brand, $product)
    {
        return Product::where('brand_id', $brand->id)
            ->where('id', '!=', $product->id)
            ->whereNotNull('name')
            ->with(['category', 'brand', 'variations' => function ($q) {
                $q->where('status', 1);
            }])
            ->withCount('variations')
            ->inRandomOrder()
            ->limit(5)
            ->get();
    }

    private function handleProductListing($paramOne, $paramTwo)
    {
        $category = Category::with(['products', 'children.products', 'parent.products'])
            ->where('slug', $paramOne)
            ->first();

        $brand = $category ? null : Brand::with('products.variations')->where('slug', $paramOne)->firstOrFail();
        $attribute_name = $paramTwo ? AttributeValue::where('slug', $paramTwo)->firstOrFail()->value : null;
        $products = $category ? $this->getCategoryProducts($category) : $brand->products()->with(['category'])->withCount('variations');

        $brands = Product::whereIn('id', $products->pluck('id'))
            ->selectRaw('brand_id, COUNT(*) as product_count')
            ->groupBy('brand_id')
            ->with('brand:id,name') // Chỉ lấy những cột cần thiết từ brand
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->brand_id,
                    'name' => $item->brand->name ?? 'Unknown',
                    'product_count' => $item->product_count,
                ];
            })
            ->where('product_count', '>', 0) // Bỏ thương hiệu có product_count = 0
            ->values(); // Reset lại index của mảng

        $products = $this->applySorting($products);


        $attributesArray = $this->formatAttribute($products);

        // dd($attributesArray);

        $products = $products->paginate(30);

        // dd($products);
        // $products = $products->toRawSql();

        // dd($products);

        return view('frontend.pages.product.list', compact('products', 'category', 'brand', 'paramOne', 'paramTwo', 'attribute_name', 'brands', 'attributesArray'));
    }

    private function formatAttribute($products)
    {
        $attributesArray = [];

        $products = $products->get(); // Lấy danh sách sản phẩm

        foreach ($products as $product) {
            foreach ($product->variations as $variation) { // Lặp qua từng biến thể
                foreach ($variation->attributes as $attribute) {
                    $attributeName = $attribute->name; // Tên thuộc tính (ví dụ: "Màu sắc")

                    // Lấy giá trị từ pivot (attribute_value_id)
                    $attributeValueId = $attribute->pivot->attribute_value_id;

                    $attributeValue = $attribute->attributeValues()
                        ->where('id', $attributeValueId)
                        ->first()
                        ->value ?? 'unknown';

                    // Bỏ qua nếu giá trị là "unknown"
                    if ($attributeValue === 'unknown') {
                        continue;
                    }

                    // Nếu thuộc tính chưa tồn tại trong mảng, khởi tạo nó
                    if (!isset($attributesArray[$attributeName])) {
                        $attributesArray[$attributeName] = [];
                    }

                    // Thêm giá trị vào mảng nếu chưa có
                    if (!in_array($attributeValue, $attributesArray[$attributeName])) {
                        $attributesArray[$attributeName][] = $attributeValue;
                    }
                }
            }
        }

        return $attributesArray;
    }




    private function getCategoryProducts($category)
    {
        // Lấy tất cả các ID danh mục liên quan (bao gồm danh mục chính, danh mục con và danh mục cha)
        $categoryIds = [$category->id];

        // Thêm các danh mục con vào mảng categoryIds
        $category->children->each(function ($child) use (&$categoryIds) {
            $categoryIds[] = $child->id;
            // Thêm các danh mục con của các danh mục con (nếu có)
            $child->children->each(function ($subChild) use (&$categoryIds) {
                $categoryIds[] = $subChild->id;
            });
        });

        // Thêm danh mục cha nếu có
        if ($category->parent) {
            $categoryIds[] = $category->parent->id;
        }

        // Lấy các sản phẩm có danh mục thuộc trong $categoryIds
        $products = Product::with(['brand', 'variations.attributes.attributeValues'])->withCount('variations')
            ->whereIn('category_id', $categoryIds); // Lọc sản phẩm theo các category_ids;

        $products = $this->applySortAttributes($products);

        return $products;
    }

    private function applyFilterBrand($products)
    {
        // Lấy mảng tên thương hiệu từ request
        $brands = request()->has('brands') && request('brands')[0] != "" ? explode(',', request('brands')[0]) : [];

        // Nếu mảng thương hiệu không trống, lọc sản phẩm theo thương hiệu
        if (count($brands) > 0) {
            $products = $products->whereIn('brand_id', function ($query) use ($brands) {
                $query->select('id')
                    ->from('brands')
                    ->whereIn('name', $brands);
            });
        }

        return $products;
    }

    private function applySortAttributes($products)
    {
        $attributes = request()->has('attrs') && request('attrs')[0] != "" ? explode(',', request('attrs')[0]) : [];

        if (!empty($attributes)) {
            $products->whereHas('variations.attributes.attributeValues', function ($query) use ($attributes) {
                $query->whereIn('value', $attributes);
            });
        }

        return $products;
    }



    private function applySorting($products)
    {
        $sortOption = request('sortOrder', 'Relevanz');

        $products =  $this->applyFilterBrand($products);

        $products->selectRaw('
        CASE
            WHEN discount_value <= 0 THEN price
            WHEN (discount_start IS NULL AND discount_end IS NULL) THEN discount_value
            WHEN (discount_start IS NOT NULL AND discount_end IS NOT NULL
                AND DATE(discount_start) <= CURDATE()
                AND DATE(discount_end) >= CURDATE())
                THEN discount_value
            WHEN discount_start IS NOT NULL AND discount_end IS NULL
                AND DATE(discount_start) <= CURDATE()
                THEN discount_value
            WHEN discount_start IS NULL AND discount_end IS NOT NULL
                AND DATE(discount_end) >= CURDATE()
                THEN discount_value
            ELSE price
        END AS final_price');

        switch ($sortOption) {
            case 'preis_desc':
                $products->orderBy('final_price', 'desc');
                break;
            case 'preis_asc':
                $products->orderBy('final_price', 'asc');
                break;
            case 'neueste':
                $products->orderByDesc('created_at');
                break;
        }

        return $products;
    }

    public function redirect($code)
    {
        $product = Product::query()->with(['brand', 'category'])->where('code', $code)->firstOrFail();

        return redirect()->route('products', [$product->category->slug, $product->brand->slug, $product->slug . '-' . $product->id]);
    }
}
