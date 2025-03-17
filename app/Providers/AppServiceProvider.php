<?php

namespace App\Providers;

use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Config;
use App\Models\Post;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        View::composer('*', function ($view) {
            $config = Config::query()->firstOrCreate();

            $view->with(['config' => $config]);
        });

        View::composer(['frontend.layouts.partials.menu_desktop', 'frontend.layouts.partials.menu_mobile'], function ($view) {
            $cacheKey = 'menu_categories';
            $cacheTime = 60 * 60;

            $categories = Cache::remember($cacheKey, $cacheTime, function () {
                $categories = Category::with([
                    'children.products.brand',
                    'products.brand',
                    'attributes'
                ])->whereNull('parent_id')->orderBy('position', 'asc')->get();

                // Lấy tất cả AttributeValue một lần duy nhất
                $attributeValues = AttributeValue::all()->keyBy('id');

                $categories->each(function ($category) use ($attributeValues) {
                    $category->brands = $category->products
                        ->pluck('brand')
                        ->filter(fn($brand) => $brand && $brand->is_top) // Lọc thương hiệu có is_top = 1
                        ->unique('id');

                    // Xử lý danh sách thuộc tính của danh mục cha
                    $category->attributes->each(function ($attribute) use ($attributeValues) {
                        $valueIds = json_decode($attribute->pivot->attribute_value_ids, true);
                        $attribute->values = collect($valueIds)->map(fn($id) => [
                            'name' => $attributeValues[$id]->value ?? null,
                            'slug' => $attributeValues[$id]->slug ?? null
                        ]);
                    });

                    // Xử lý danh mục con
                    $category->children->each(function ($child) use ($attributeValues) {
                        $child->brands = $child->products
                            ->pluck('brand')
                            ->filter(fn($brand) => $brand && $brand->is_top)
                            ->unique('id');

                        $child->attributes->each(function ($attribute) use ($attributeValues) {
                            $valueIds = json_decode($attribute->pivot->attribute_value_ids, true);
                            $attribute->values = collect($valueIds)->map(fn($id) => [
                                'name' => $attributeValues[$id]->value ?? null,
                                'slug' => $attributeValues[$id]->slug ?? null
                            ]);
                        });
                    });
                });

                return $categories;
            });

            $view->with(['categories' => $categories]);
        });

        View::composer('frontend.layouts.partials.footer', function ($view) {
            $newPosts = Post::query()
                ->published()
                ->orderByRaw('COALESCE(published_at, created_at) DESC')->limit(7)->get();

            $view->with(['newPosts' => $newPosts]);
        });
    }
}
