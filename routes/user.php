<?php

use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Slider;
use Illuminate\Support\Facades\Route;


route::get('/', function () {

    $slider =  Slider::query()->where('type', 'big')->first();

    $sliders = collect($slider->items)->sortBy('position')->values()->all();

    $sliderSmall = Slider::query()->where('type', 'small')->limit(2)->get();

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

    $brands = Brand::query()->limit(8)->orderBy('position', 'asc')->where('status', 1)->get();

    return view('frontend.pages.home', compact('categories', 'brands', 'sliders', 'sliderSmall'));
});
