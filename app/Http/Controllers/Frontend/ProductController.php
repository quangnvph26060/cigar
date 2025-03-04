<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function productList($paramOne = null, $paramTwo = null, $paramThree = null)
    {
        if ($paramThree) {
            preg_match('/-(\d+)$/', $paramThree, $matches);

            $product = Product::query()
                ->with([
                    'variations' => function ($q) {
                        $q->where('status', 1);
                    },
                    'variations.priceVariants' // Nạp thêm quan hệ priceVariants từ variations
                ])
                ->withCount('variations')
                ->findOrFail($matches[1]);

            $unpublishedVariations = $product->variations()
                ->where('status', 2)
                ->get();

            // Lấy ID của thương hiệu từ slug
            $brand = Brand::where('slug', $paramTwo)->firstOrFail();

            // Truy vấn sản phẩm liên quan
            $relatedProducts = Product::query()
                ->where('brand_id', $brand->id)
                ->where('id', '!=', $product->id)
                ->whereNotNull('name')
                ->with(['brand', 'variations' => function ($q) {
                    $q->where('status', 1);
                }])
                ->withCount('variations')
                ->inRandomOrder()
                ->limit(5)
                ->get();



            return view('frontend.pages.product.product-variants', compact('product', 'relatedProducts', 'unpublishedVariations'));
        }


        // Kiểm tra xem có $paramOne (danh mục hiện tại) hay không
        if ($paramOne) {
            // Lấy danh mục hiện tại
            $category = Category::with([
                'products', // Lấy sản phẩm của danh mục hiện tại
                'children.products', // Lấy sản phẩm của các danh mục con
                'parent.products' // Lấy sản phẩm của danh mục cha
            ])->where('slug', $paramOne)->first();

            // Nếu có danh mục hiện tại
            if ($category) {
                // Lấy tất cả các sản phẩm của danh mục hiện tại, danh mục cha và các danh mục con
                $products = $category->products()->with(['brand'])->withCount('variations'); // Lấy sản phẩm của danh mục hiện tại

                // Lấy sản phẩm của các danh mục con
                $category->children->each(function ($child) use (&$products) {
                    $products = $products->merge($child->products);
                    // Nếu có danh mục con của danh mục con, đệ quy tiếp tục
                    if ($child->children->isNotEmpty()) {
                        $child->children->each(function ($subChild) use (&$products) {
                            $products = $products->merge($subChild->products);
                        });
                    }
                });

                // Lấy sản phẩm của danh mục cha
                if ($category->parent) {
                    $products = $products->merge($category->parent->products);
                }

                // Sử dụng phân trang (paginate) với 30 sản phẩm mỗi trang
                $products = $products->paginate(30);

                return view('frontend.pages.product.list', compact('products', 'category'));
            }
        }

        // Nếu không có paramOne, trả về view mà không có sản phẩm
        // return view('frontend.pages.product.list');
    }
}
