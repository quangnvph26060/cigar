<?php

namespace App\Providers;

use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Config;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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

        View::composer('frontend.layouts.partials.menu_desktop', function ($view) {

            $categories = Category::with([
                'children' => function ($query) {
                    $query->with(['products.brand']);
                },
                'products.brand'
            ])->whereNull('parent_id')->get();


            $categories->each(function ($category) {
                // Lấy tất cả các thương hiệu của các sản phẩm trong danh mục này
                $brands = $category->products->pluck('brand')->filter()->unique('id'); // Lọc và loại bỏ các giá trị null
                $category->brands = $brands;

                // Lặp qua các danh mục con
                $category->children->each(function ($child) {
                    $brands = $child->products->pluck('brand')->filter()->unique('id');
                    $child->brands = $brands;
                });
            });

            $attributeValueMap = AttributeValue::pluck('value', 'id');

            $categories->each(function ($category) use ($attributeValueMap) {
                $category->attributes->each(function ($attribute) use ($attributeValueMap) {
                    $valueIds = json_decode($attribute->pivot->attribute_value_ids, true);

                    $attribute->values = array_map(function ($id) use ($attributeValueMap) {
                        $attributeValue = AttributeValue::find($id);
                        return [
                            'name' => $attributeValue->value ?? null, // Lấy giá trị name
                            'slug' => $attributeValue->slug ?? null  // Lấy giá trị slug
                        ];
                    }, $valueIds);
                });

                $category->children->each(function ($child) use ($attributeValueMap) {
                    $child->attributes->each(function ($attribute) use ($attributeValueMap) {
                        $valueIds = json_decode($attribute->pivot->attribute_value_ids, true);

                        $attribute->values = array_map(function ($id) use ($attributeValueMap) {
                            $attributeValue = AttributeValue::find($id);
                            return [
                                'name' => $attributeValue->value ?? null,
                                'slug' => $attributeValue->slug ?? null
                            ];
                        }, $valueIds);
                    });
                });
            });

            // dd($categories);

            $view->with(['categories' => $categories]);
        });
    }
}
