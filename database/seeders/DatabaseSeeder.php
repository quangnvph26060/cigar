<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // for ($i = 1; $i <= 5000; $i++) {
        //     DB::table('products')->insert([
        //         'category_id'     => fake()->numberBetween(17, 23), // category_id ngẫu nhiên từ 17-23
        //         'brand_id'        => fake()->numberBetween(1, 9), // brand_id ngẫu nhiên từ 1-9
        //         'code'            => 'SP' . fake()->unique()->numberBetween(1000, 9999), // Mã sản phẩm duy nhất
        //         'qr_code'         => fake()->uuid, // QR Code ngẫu nhiên
        //         'name'            => fake()->word, // Tên sản phẩm
        //         'slug'            => fake()->slug . '-' . $i, // Đảm bảo slug duy nhất
        //         'price'           => fake()->randomFloat(2, 2, 99),
        //         'discount_value'  => fake()->optional()->randomFloat(2, 0, 500), // Giá trị giảm giá (tùy chọn)
        //         'discount_start'  => fake()->date(), // Ngày bắt đầu giảm giá
        //         'discount_end'    => fake()->date(), // Ngày kết thúc giảm giá
        //         'image'           => fake()->imageUrl(640, 480, 'products'), // URL ảnh giả
        //         'videos'          => fake()->url, // URL video giả
        //         'description'     => fake()->paragraph, // Mô tả sản phẩm
        //         'tags'            => null, // Tags là null
        //         'seo_title'       => fake()->sentence(6), // Tiêu đề SEO
        //         'seo_description' => fake()->sentence(10), // Mô tả SEO
        //         'seo_keywords'    => null, // SEO keywords là null
        //         'status'          => fake()->randomElement([1, 2]), // Trạng thái ngẫu nhiên (1 hoặc 2)
        //         'created_at'      => now(),
        //         'updated_at'      => now(),
        //     ]);
        // }

        // for ($i = 0; $i < 10000; $i++) {
        //     DB::table('variations')->insert([
        //         'product_id' => fake()->numberBetween(3, 5232), // Giả sử có 100 sản phẩm
        //         'name' => fake()->word,
        //         'slug' => fake()->slug,
        //         'image' => fake()->imageUrl(640, 480, 'products'),
        //         'description' => fake()->paragraph,
        //         'rating' => fake()->randomFloat(1, 1, 5), // Đánh giá từ 1 đến 5
        //         'quality' => fake()->randomElement(['Low', 'Medium', 'High']),
        //         'strength' => fake()->randomElement(['Weak', 'Medium', 'Strong']),
        //         'radius' => fake()->randomFloat(2, 1, 50), // Giả sử bán kính từ 1 đến 50
        //         'length' => fake()->randomFloat(2, 1, 100), // Giả sử chiều dài từ 1 đến 100
        //         'prices' => fake()->randomFloat(2, 10, 1000), // Giá từ 10 đến 1000
        //         'quantity' => fake()->numberBetween(1, 100), // Số lượng từ 1 đến 100
        //         'unit' => fake()->randomElement(['kg', 'm', 'piece']),
        //         'tags' => implode(',', fake()->words(5)), // Tags là một chuỗi từ
        //         'seo_title' => fake()->sentence,
        //         'seo_description' => fake()->paragraph,
        //         'seo_keywords' => implode(',', fake()->words(10)),
        //         'status' => fake()->randomElement([0, 1]), // Trạng thái 0 hoặc 1
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }

        // for ($i = 0; $i < 1000; $i++) { // Thay 100 bằng số bản ghi bạn muốn tạo
        //     // Số lượng biến thể ngẫu nhiên từ 1 đến 3
        //     $variantCount = rand(1, 3);
        //     $prices = [];

        //     // Tạo ra giá cho từng biến thể
        //     for ($j = 0; $j < $variantCount; $j++) {
        //         $prices[] = rand(100000, 300000);
        //     }

        //     DB::table('price_variants')->insert([
        //         'variation_id' => rand(17, 10000),
        //         'price' => fake()->randomFloat(2, 10, 1000),
        //         'discount_value' => rand(0, 50000), // Thay đổi theo nhu cầu
        //         'discount_start' => now(),
        //         'discount_end' => now()->addDays(rand(1, 30)),
        //         'unit' => 'bao', // Hoặc 'hộp', tùy thuộc vào nhu cầu
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // $now = Carbon::now();


        // for ($i = 1; $i <= 20; $i++) {
        //     Post::create([
        //         'title'            => "Bài viết thử nghiệm $i",
        //         'slug'             => Str::slug("Bài viết thử nghiệm $i"),
        //         'image'            => "https://via.placeholder.com/600x400?text=Post+$i",
        //         'content'          => "Đây là nội dung của bài viết thử nghiệm số $i.",
        //         'excerpt'          => "Mô tả ngắn của bài viết thử nghiệm số $i.",
        //         'seo_title'        => "SEO Title bài viết $i",
        //         'seo_description'  => "SEO Description cho bài viết $i",
        //         'seo_keywords'     => null,
        //         'seo_tags'         => null,
        //         'status'           => 1,
        //         'featured'         => rand(0, 1),
        //         'published_at'     => rand(0, 1) ? $now->subDays(rand(1, 30)) : null,
        //         'removed_at'       => rand(0, 1) ? $now->addDays(rand(1, 30)) : null,
        //         'created_at'       => $now->subDays(rand(10, 50)),
        //         'updated_at'       => $now->subDays(rand(1, 10)),
        //     ]);
        // }
    }
}
