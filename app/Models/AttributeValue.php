<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'attribute_id',
        'value',
        'slug',
        'image',
        'description',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'status'
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    protected $casts = [
        'seo_keywords' => 'array'
    ];
}
