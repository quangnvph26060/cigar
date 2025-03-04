<?php

namespace App\Http\Controllers\Backend\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostRequest;
use App\Models\Post;
use App\Services\BaseQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PostController extends Controller
{


    protected $queryBuilder;

    public function __construct()
    {
        $this->queryBuilder = new BaseQuery(Post::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $columns    = ['id', 'title', 'slug', 'image', 'status', 'featured', 'published_at', 'removed_at'];

            $query      = $this->queryBuilder->buildQuery(
                $columns,
                [],
                [],
                request()
            );

            return $this->queryBuilder->processDataTable($query, function ($dataTable) {
                return $dataTable
                    ->editColumn('slug', fn($row) => '<a target="_blank" href="' . env('APP_URL') . '/' . $row->slug . '">' . $row->slug . '</a>')
                    ->editColumn('removed_at', fn($row) => $row->removed_at ? Carbon::parse($row->removed_at)->format('d-m-Y H:i:s') : 'Đang cập nhật...')
                    ->editColumn('published_at', fn($row) => $row->published_at ? Carbon::parse($row->published_at)->format('d-m-Y H:i:s') : 'Đang cập nhật...');
            }, ['slug']);
        }
        return view('backend.post.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.post.save', ['post' => null]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        return transaction(function () use ($request) {
            $credentials = $request->validated();

            $credentials['slug'] ??= generateSlug($credentials['title']);

            if ($request->hasFile('image')) {
                $credentials['image'] = uploadImages($request->file('image'), 'posts');
            }

            $credentials['featured'] = isset($credentials['featured']) && $credentials['featured'] == 'on' ? true : false;

            Post::create($credentials);

            handleResponse('Lưu thành công.', 201);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('backend.post.save', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        return transaction(function () use ($request, $post) {
            $credentials = $request->validated();

            $credentials['slug'] ??= generateSlug($credentials['title']);

            if ($request->hasFile('image')) {
                $credentials['image'] = uploadImages($request->file('image'), 'posts');
                deleteImage($post->image);
            }

            $credentials['featured'] = isset($credentials['featured']) && $credentials['featured'] == 'on' ? true : false;

            $post->update($credentials);

            handleResponse('Lưu thay đổi thành công.', 200);
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
