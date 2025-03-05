<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'category_id',
        'brand_id',
        'code',
        'qr_code',
        'name',
        'slug',
        'price',
        'discount_value',
        'discount_start',
        'discount_end',
        'image',
        'videos',
        'description',
        'short_description',
        'tags',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'status'
    ];
    public $timestamps = true;

    protected $casts = [
        'discount_start' => 'date',
        'discount_end' => 'date',
    ];

    public function variations()
    {
        return $this->hasMany(Variation::class);
    }

    // Trong mô hình Product
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


}
