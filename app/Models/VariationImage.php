<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariationImage extends Model
{
    use HasFactory;
    protected $table = 'variation_images';
    protected $fillable = ['variation_id', 'image_path'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
