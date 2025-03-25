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
use Illuminate\Support\Facades\DB;

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
        Cache::flush();
        // Tạo key cache duy nhất dựa vào các tham số
        $cacheKey = "product_listing_{$paramOne}_{$paramTwo}_" . request('brands') . "_" . request('attrs') . "_" . request('sortOrder') . "_" .  request('page');

        // Lưu cache danh sách sản phẩm
        $data = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($paramOne, $paramTwo) {
            $category = Category::with(['products', 'children.products', 'parent.products'])
                ->where('slug', $paramOne)
                ->first();

            $brand = $category ? null : Brand::with('products.variations')->where('slug', $paramOne)->firstOrFail();

            $attribute = $paramTwo ? AttributeValue::where('slug', $paramTwo)->firstOrFail() : null;

            $ids = $category ? $this->getCategoryProducts($category) : [$brand->id];

            $products = Product::query()->with(['variations', 'brand', 'category'])->withCount('variations')
                ->whereIn($category ? 'category_id' : 'brand_id', $ids);

            if ($attribute) {
                $products = $products->whereHas('variations', function ($q) use ($attribute) {
                    $q->whereHas('attributes', function ($q) use ($attribute) {
                        $q->where('attribute_value_id', $attribute->id);
                    });
                });
            }

            $brands = $products->get()->groupBy('brand_id')->map(function ($items) {
                return [
                    'id' => $items->first()->brand_id,
                    'brand_name' => $items->first()->brand->name,
                    'product_count' => $items->count()
                ];
            });

            $attributesArray = $this->formatAttribute($products);

            $products = $this->applySortAttributes($products);
            $products = $this->applyFilterBrand($products);
            $products = $this->applySorting($products);
            $products = $products->paginate(30);

            return compact('products', 'category', 'brand', 'paramOne', 'paramTwo', 'attribute', 'brands', 'attributesArray');
        });

        // Trả về view với dữ liệu từ cache
        return view('frontend.pages.product.list', $data);
    }

    private function formatAttribute($products)
    {
        $attributesArray = [];

        // Lấy toàn bộ sản phẩm kèm biến thể và thuộc tính ngay từ đầu
        $products = $products->with([
            'variations.attributes.attributeValues'
        ])->get();

        foreach ($products as $product) {
            foreach ($product->variations as $variation) {
                foreach ($variation->attributes as $attribute) {
                    $attributeName = $attribute->name; // Ví dụ: "Màu sắc"

                    // Lấy tất cả giá trị của thuộc tính
                    foreach ($attribute->attributeValues as $value) {
                        $attributeValue = $value->value;

                        // Khởi tạo nếu chưa có
                        if (!isset($attributesArray[$attributeName])) {
                            $attributesArray[$attributeName] = [];
                        }

                        // Tăng biến đếm số lượng biến thể có giá trị đó
                        if (!isset($attributesArray[$attributeName][$attributeValue])) {
                            $attributesArray[$attributeName][$attributeValue] = 0;
                        }

                        $attributesArray[$attributeName][$attributeValue]++;
                    }
                }
            }
        }

        return $attributesArray;
    }

    private function getCategoryProducts($category)
    {
        if (!$category) {
            return [];
        }

        $categoryIds = collect([$category->id])
            ->merge(optional($category->children)->pluck('id') ?? [])
            ->merge(optional($category->children)->flatMap->children->pluck('id') ?? [])
            ->merge(optional($category->parent)->id ? [$category->parent->id] : []);

        return $categoryIds->filter()->unique()->toArray();
    }



    private function applyFilterBrand($products)
    {
        $brandNames = request()->has('brands') && request('brands')[0] != "" ? explode(',', request('brands')[0]) : [];

        if (!empty($brandNames)) {
            $brandIds = Brand::whereIn('name', $brandNames)->pluck('id')->toArray();
            if (!empty($brandIds)) {
                $products->orWhereIn('brand_id', $brandIds);
            }
        }

        return $products;
    }



    private function applySortAttributes($products)
    {
        $attributes = request()->has('attrs') && request('attrs')[0] != "" ? explode(',', request('attrs')[0]) : [];

        if (!empty($attributes)) {
            $products->whereHas('variations.attributes.attributeValues', fn($q) => $q->whereIn('value', $attributes));
        }

        return $products;
    }

    private function applySorting($products)
    {
        $sortOption = request('sortOrder', 'Relevanz');

        $products->selectRaw("
            products.id,
            products.name,
            products.price,
            products.discount_value,
            products.discount_start,
            products.discount_end,
            CASE
                WHEN discount_value <= 0 THEN price
                WHEN (discount_start IS NULL AND discount_end IS NULL) THEN discount_value
                WHEN (discount_start IS NOT NULL AND discount_end IS NOT NULL
                    AND DATE(discount_start) <= CURDATE()
                    AND DATE(discount_end) >= CURDATE()) THEN discount_value
                WHEN (discount_start IS NOT NULL AND discount_end IS NULL
                    AND DATE(discount_start) <= CURDATE()) THEN discount_value
                WHEN (discount_start IS NULL AND discount_end IS NOT NULL
                    AND DATE(discount_end) >= CURDATE()) THEN discount_value
                ELSE price
            END AS final_price
        ");

        return match ($sortOption) {
            'preis_desc' => $products->orderByRaw('final_price DESC'),
            'preis_asc' => $products->orderByRaw('final_price ASC'),
            'neueste' => $products->orderByDesc('created_at'),
            default => $products
        };
    }




    public function redirect($code)
    {
        $product = Product::query()->with(['brand', 'category'])->where('code', $code)->firstOrFail();

        return redirect()->route('products', [$product->category->slug, $product->brand->slug, $product->slug . '-' . $product->id]);
    }
}
