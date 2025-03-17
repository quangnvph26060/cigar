<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BrandController extends Controller
{
    public function index($slug = null)
    {
        if ($slug) {
            // Lấy danh mục theo slug
            $category = Category::where('slug', $slug)->firstOrFail();

            // Lấy ID sản phẩm thuộc danh mục đó
            $productIds = $category->products()->pluck('id');

            // Lấy danh sách thương hiệu từ các sản phẩm (không trùng nhau)
            $brands = Brand::whereHas('products', function ($query) use ($productIds) {
                $query->whereIn('id', $productIds);
            })
                ->select('id', 'name', 'image', 'slug')
                ->withCount(['products' => function ($query) use ($productIds) {
                    $query->whereIn('id', $productIds);
                }])
                ->orderBy('name', 'asc')
                ->get();
        } else {
            // Lấy toàn bộ thương hiệu
            $brands = Brand::select('id', 'name', 'image', 'slug')
                ->withCount('products')
                ->orderBy('name', 'asc')
                ->get();
        }

        // Nhóm thương hiệu theo chữ cái đầu tiên
        $groupedBrands = $brands->groupBy(function ($brand) {
            $firstChar = strtoupper(substr($brand->name, 0, 1));
            return preg_match('/[A-Z]/', $firstChar) ? $firstChar : '#';
        });

        // Chuyển sang mảng để sắp xếp
        $brandsArray = $groupedBrands->toArray();

        // Đưa nhóm "#" xuống cuối
        $specialGroup = $brandsArray['#'] ?? null;
        unset($brandsArray['#']);

        ksort($brandsArray);
        if ($specialGroup) {
            $brandsArray['#'] = $specialGroup;
        }

        // Tổng số thương hiệu
        $totalBrands = collect($brandsArray)->sum(fn($group) => count($group));

        return view('frontend.pages.brand', [
            'brands' => collect($brandsArray),
            'totalBrands' => $totalBrands,
            'category' => $slug ? $category : null
        ]);
    }
}
