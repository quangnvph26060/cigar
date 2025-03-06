<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PriceVariant;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Variation;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function home()
    {
        $sliders = Slider::query()->orderBy('position', 'asc')->get();

        $posts = Post::query()->where('featured', true)->limit(4)->latest()->get();

        $brands = Brand::query()->limit(8)->orderBy('position', 'asc')->where('status', 1)->get();

        $newVariants = Variation::query()
            ->with('priceVariants')
            ->where('created_at', '>=', now()->subDays(7))
            ->limit(7)
            ->latest()
            ->get();

        $discountVariants = Variation::query()
            ->with('priceVariants')
            ->whereHas('priceVariants', function ($query) {
                $query->where('discount_value', '>', 0)
                    ->where(function ($q) {
                        $q->whereNull(['discount_start', 'discount_end'])
                            ->orWhere(function ($q2) {
                                $q2->whereNotNull('discount_start')
                                    ->whereNotNull('discount_end')
                                    ->whereDate('discount_start', '<=', now()->toDateString())
                                    ->whereDate('discount_end', '>=', now()->toDateString());
                            });
                    });
            })
            ->latest()
            ->limit(7)
            ->get();

        // Truy vấn thêm sản phẩm có status = 2
        $statusTwoProducts = Product::query()
            ->where('status', 2)
            ->with(['category', 'brand'])
            ->latest()
            ->limit(7)
            ->get();

        return view('frontend.pages.home', compact(
            'brands',
            'sliders',
            'posts',
            'newVariants',
            'discountVariants',
            'statusTwoProducts' // Truyền thêm biến này qua view
        ));
    }
}
