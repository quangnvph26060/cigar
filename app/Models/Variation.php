<?php

namespace App\Models;

use App\Models\VariationAttributeValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    use HasFactory;
    protected $table = 'variations';

    protected $fillable = [
        'product_id',
        'name',
        'slug',
        'image',
        'description',
        'short_description',
        'rating',
        'quality',
        'strength',
        'radius',
        'length',
        'quantity',
        'unit',
        'tags',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'status'
    ];
    public $timestamps = true;

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'variation_attribute_values', 'variations_id')->withPivot('attribute_value_id');
    }

    public function priceVariants()
    {
        return $this->hasMany(PriceVariant::class);
    }

    public function getOnePriceVariant()
    {
        return $this->hasOne(PriceVariant::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
