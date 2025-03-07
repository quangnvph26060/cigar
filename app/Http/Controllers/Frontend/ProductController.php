<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Variation;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function productList($paramOne = null, $paramTwo = null, $paramThree = null)
    {
        // $sortOption = request('sortOrder', 'Relevanz');

        // if ($paramThree) {
        //     preg_match('/-(\d+)$/', $paramThree, $matches);

        //     $product = Product::query()
        //         ->with([
        //             'variations' => function ($q) {
        //                 $q->where('status', 1);
        //             },
        //             'variations.priceVariants' // Nạp thêm quan hệ priceVariants từ variations
        //         ])
        //         ->withCount('variations')
        //         ->findOrFail($matches[1]);

        //     $unpublishedVariations = $product->variations()
        //         ->where('status', 2)
        //         ->get();

        //     // Lấy ID của thương hiệu từ slug
        //     $brand = Brand::where('slug', $paramTwo)->firstOrFail();

        //     // Truy vấn sản phẩm liên quan
        //     $relatedProducts = Product::query()
        //         ->where('brand_id', $brand->id)
        //         ->where('id', '!=', $product->id)
        //         ->whereNotNull('name')
        //         ->with(['brand', 'variations' => function ($q) {
        //             $q->where('status', 1);
        //         }])
        //         ->withCount('variations')
        //         ->inRandomOrder()
        //         ->limit(5)
        //         ->get();

        //     return view('frontend.pages.product.product-variants', compact('product', 'relatedProducts', 'unpublishedVariations'));
        // }


        // // Kiểm tra xem có $paramOne (danh mục hiện tại) hay không
        // if ($paramOne) {
        //     $brand = null;
        //     // Tìm danh mục dựa trên slug
        //     $category = Category::with([
        //         'products',
        //         'children.products',
        //         'parent.products'
        //     ])->where('slug', $paramOne)->first();

        //     // Nếu không tìm thấy danh mục, tìm theo Brand
        //     if (!$category) {
        //         $brand = Brand::with('products.variations')->where('slug', $paramOne)->firstOrFail();
        //     }

        //     // Nếu tìm thấy danh mục (category)
        //     if ($category) {
        //         $products = $category->products()->with(['brand'])->withCount('variations');

        //         // Lấy sản phẩm của danh mục con
        //         $category->children->each(function ($child) use (&$products) {
        //             $products = $products->merge($child->products);
        //             if ($child->children->isNotEmpty()) {
        //                 $child->children->each(function ($subChild) use (&$products) {
        //                     $products = $products->merge($subChild->products);
        //                 });
        //             }
        //         });

        //         // Lấy sản phẩm của danh mục cha
        //         if ($category->parent) {
        //             $products = $products->merge($category->parent->products);
        //         }
        //     } else {
        //         // Nếu tìm thấy Brand, lấy tất cả sản phẩm của thương hiệu đó
        //         $products = $brand->products()->with(['category'])->withCount('variations');
        //     }

        //     // Áp dụng logic sắp xếp giá
        //     $products->selectRaw('
        //         CASE
        //             WHEN discount_value <= 0 THEN price
        //             WHEN (discount_start IS NULL AND discount_end IS NULL) THEN discount_value
        //             WHEN (discount_start IS NOT NULL AND discount_end IS NOT NULL AND
        //                 (CAST(discount_start AS DATETIME) <= NOW() AND CAST(discount_end AS DATETIME) >= NOW()))
        //                 THEN discount_value
        //             WHEN discount_start IS NOT NULL AND discount_end IS NULL AND CAST(discount_start AS DATETIME) <= NOW()
        //                 THEN discount_value
        //             WHEN discount_start IS NULL AND discount_end IS NOT NULL AND CAST(discount_end AS DATETIME) >= NOW()
        //                 THEN discount_value
        //             ELSE price
        //         END as final_price');

        //     // Áp dụng sắp xếp theo lựa chọn của người dùng
        //     switch ($sortOption) {
        //         case 'preis_desc':
        //             $products->orderBy('final_price', 'desc');
        //             break;
        //         case 'preis_asc':
        //             $products->orderBy('final_price', 'asc');
        //             break;
        //         case 'neueste':
        //             $products->orderByDesc('created_at');
        //             break;
        //         default:
        //             // Mặc định không sắp xếp
        //             break;
        //     }

        //     // Phân trang
        //     $products = $products->paginate(30);

        //     return view('frontend.pages.product.list', compact('products', 'category', 'brand'));
        // }


        // Nếu không có paramOne, trả về view mà không có sản phẩm
        // return view('frontend.pages.product.list');
    }
}
