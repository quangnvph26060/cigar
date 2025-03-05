<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'image',
        'description',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'position',
        'status'
    ];

    protected $casts = [
        'seo_keywords' => 'array'
    ];

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'category_attributes', 'category_id', 'attribute_id')->withPivot('attribute_value_ids');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
