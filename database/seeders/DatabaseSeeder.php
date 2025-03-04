<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
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
