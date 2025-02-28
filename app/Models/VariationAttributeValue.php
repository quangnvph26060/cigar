<?php

namespace App\Models;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariationAttributeValue extends Model
{
    use HasFactory;
    protected $table = 'variation_attribute_values';
    protected $guarded = [];
    public $timestamps = true;

    public function variation(){
        return $this->belongsTo(Variation::class);
    }
    public function attributeValue(){
        return $this->belongsTo(AttributeValue::class);
    }
    public function attribute(){
        return $this->belongsTo(Attribute::class);
    }
}
