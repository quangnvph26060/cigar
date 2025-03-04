<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'items',
        'position'
    ];

    protected $casts = [
        'items' => 'array'
    ];

    public function getSortedItemsAttribute()
    {
        $items = $this->items;
        if (!is_array($items)) return [];

        usort($items, fn($a, $b) => $a['position'] <=> $b['position']);
        return $items;
    }
}
