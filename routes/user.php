<?php

use App\Models\AttributeValue;
use App\Models\Category;
use Illuminate\Support\Facades\Route;


route::get('/', function () {

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


    return view('frontend.layouts.master', compact('categories'));
});
