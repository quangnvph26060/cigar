<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'variation_id',
        'price_variant_id',
        'p_name',
        'p_image',
        'p_price',
        'p_qty',
        'p_unit'
    ];
}
