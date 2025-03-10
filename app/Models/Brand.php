<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'status'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
