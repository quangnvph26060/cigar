<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'excerpt',
        'title',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'position',
        'is_show_home',
        'is_top',
        'status'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    protected $casts = [
        'is_show_home' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            Cache::forget('menu_categories');
        });

        static::deleted(function () {
            Cache::forget('menu_categories');
        });
    }
}
