<?php

namespace App\Models;

use App\Models\VariationAttributeValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    use HasFactory;
    protected $table = 'variations';
    protected $guarded = [];
    public $timestamps = true;

    public function attributes(){
        return $this->belongsToMany(Attribute::class, 'variation_attribute_values', 'variations_id')->withPivot('attribute_value_id');
    }

}
