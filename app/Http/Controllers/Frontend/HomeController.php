<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Post;
use App\Models\Slider;

class HomeController extends Controller
{
    public function home()
    {
        $sliders = Slider::query()->orderBy('position', 'asc')->get();

        $posts = Post::query()->where('featured', true)->limit(4)->latest()->get();

        $brands = Brand::query()->limit(8)->orderBy('position', 'asc')->where('status', 1)->get();

        return view('frontend.pages.home', compact('brands', 'sliders', 'posts'));
    }
}
