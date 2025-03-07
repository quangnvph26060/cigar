<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ConfigFilter extends Model
{
    use HasFactory;

    protected $fillable = [
        'filter_type',
        'title',
        'attribute_id',
        'option_price',
        'location',
        'selection_type'
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public static function boot()
    {
        parent::boot();

        static::saved(function () {
            Cache::clear();
        });
    }
}
