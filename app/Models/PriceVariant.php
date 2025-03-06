<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'variation_id',
        'price',
        'discount_value',
        'discount_start',
        'discount_end',
        'unit'
    ];

    public function variant()
    {
        return $this->belongsTo(Variation::class, 'variation_id');
    }

    protected $casts = [
        'discount_end' => 'date',
        'discount_start' => 'date'
    ];
}
