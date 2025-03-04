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
                'attributes:id,name',
                'children.attributes:id,name',
            ])->whereNull('parent_id')->get();

            $attributeValueMap = AttributeValue::pluck('value', 'id');

            $categories->each(function ($category) use ($attributeValueMap) {
                $category->attributes->each(function ($attribute) use ($attributeValueMap) {
                    $valueIds = json_decode($attribute->pivot->attribute_value_ids, true);
                    $attribute->values = array_map(fn($id) => $attributeValueMap[$id] ?? null, $valueIds);
                });

                $category->children->each(function ($child) use ($attributeValueMap) {
                    $child->attributes->each(function ($attribute) use ($attributeValueMap) {
                        $valueIds = json_decode($attribute->pivot->attribute_value_ids, true);
                        $attribute->values = array_map(fn($id) => $attributeValueMap[$id] ?? null, $valueIds);
                    });
                });
            });

            $view->with(['categories' => $categories]);
        });
    }
}
