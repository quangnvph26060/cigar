<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function home()
    {

        // Brand::query()->inRandomOrder()->limit(30)->update(['is_top' => 1]);

        // Product::query()->inRandomOrder()->limit(150)->update(['status' => 2]);

        // $manager = new ImageManager(['driver' => 'gd']);

        // // Đường dẫn tới thư mục chứa ảnh (public/storage/products)
        // $directory = public_path('storage/products');
        // $outputDir = public_path('storage/products/resized'); // Thư mục lưu ảnh sau khi xử lý

        // // Kiểm tra nếu thư mục không tồn tại thì tạo mới
        // if (!file_exists($outputDir)) {
        //     mkdir($outputDir, 0777, true);
        // }

        // $files = scandir($directory);
        // $fixedWidth = 278;
        // $fixedHeight = 175;

        // foreach ($files as $file) {
        //     if (!in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) {
        //         continue;
        //     }

        //     $path = $directory . '/' . $file;
        //     $image = $manager->make($path);

        //     // Tạo một canvas có kích thước cố định
        //     $canvas = $manager->canvas($fixedWidth, $fixedHeight, '#ffffff'); // Nền trắng

        //     // Resize ảnh giữ nguyên tỉ lệ, không làm méo
        //     $image->resize($fixedWidth, $fixedHeight, function ($constraint) {
        //         $constraint->aspectRatio();
        //         $constraint->upsize();
        //     });

        //     // Căn giữa ảnh trên canvas
        //     $canvas->insert($image, 'center');

        //     // Lưu ảnh vào thư mục resized
        //     $canvas->save($outputDir . '/' . $file);
        // }

        // return "Xử lý ảnh hoàn tất! Ảnh đã lưu trong public/storage/products/resized/";

        // Cache::flush();

        $sliders = Slider::query()->orderBy('position', 'asc')->get();

        $posts = Post::query()->where('featured', true)->limit(4)->latest()->get();

        $brands = Brand::query()->limit(8)->orderBy('position', 'asc')->where('is_show_home', 1)->where('status', 1)->get();

        $newProducts = Cache::remember('new_products', now()->addDay(), function () {
            return Product::query()
                ->where('created_at', '>=', now()->subDays(7))
                ->whereNotNull('name')
                ->inRandomOrder()
                ->limit(7)
                ->latest()
                ->get();
        });

        $discountProducts = Cache::remember('discount_products', now()->addDay(), function () {
            return Product::query()
                ->where('discount_value', '>', 0)
                ->where(function ($q) {
                    $q->whereNull('discount_start')
                        ->whereNull('discount_end')
                        ->orWhere(function ($q2) {
                            $q2->whereNotNull('discount_start')
                                ->whereNotNull('discount_end')
                                ->whereDate('discount_start', '<=', now()->toDateString())
                                ->whereDate('discount_end', '>=', now()->toDateString());
                        });
                })
                ->inRandomOrder()
                ->whereNotNull('name')
                ->latest()
                ->limit(7)
                ->get();
        });

        // Lưu cache danh sách sản phẩm ngừng bán
        $stoppedProducts = Cache::remember('stopped_products', now()->addDay(), function () {
            return Product::query()
                ->where('status', 2)
                ->with(['category', 'brand'])
                ->whereNotNull('name')
                ->inRandomOrder()
                ->latest()
                ->limit(7)
                ->get();
        });

        // Lưu cache danh sách sản phẩm bán chạy
        $bestsellerProducts = Cache::remember('bestseller_products', now()->addDay(), function () {
            return Product::leftJoin('order_details', 'products.id', '=', 'order_details.product_id')
                ->select(
                    'products.id',
                    'products.name',
                    'products.slug',
                    'products.image',
                    DB::raw('COALESCE(SUM(order_details.p_qty), 0) as total_sold')
                )
                ->groupBy('products.id', 'products.name', 'products.slug', 'products.image') // Thêm các cột vào GROUP BY
                ->orderByDesc('total_sold')
                ->limit(7)
                ->get();
        });



        return view('frontend.pages.home', compact(
            'brands',
            'sliders',
            'posts',
            'newProducts',
            'discountProducts',
            'stoppedProducts',
            'bestsellerProducts'
        ));
    }
}
