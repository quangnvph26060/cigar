<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function content($slug = null)
    {
        // Lấy danh sách bài viết phân trang
        $posts = Post::query()
            ->published()
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->paginate(9);

        // Nếu có slug, lấy bài viết duy nhất
        $post = $slug ? Post::query()->where('slug', $slug)->first() : null;

        // Truyền cả $post và $posts cho view
        return view('frontend.pages.content', compact('post', 'posts'));
    }
}
