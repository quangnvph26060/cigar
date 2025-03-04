<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'image',
        'content',
        'excerpt',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'seo_tags',
        'status',
        'featured',
        'published_at',
        'removed_at'
    ];

    protected $casts = [
        'seo_keywords' => 'array',
        'seo_tags'  => 'array',
        'featured' => 'boolean',
        'published_at' => 'datetime',
        'removed_at' => 'datetime',
    ];

    public function scopePublished(Builder $query)
    {
        $now = Carbon::now()->toDateTimeString(); // Lấy ngày giờ hiện tại với định dạng đầy đủ

        return $query->where('status', 1)
            ->where(function ($query) use ($now) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', $now); // So sánh chính xác cả ngày giờ
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('removed_at')
                    ->orWhere('removed_at', '>=', $now); // So sánh chính xác cả ngày giờ
            });
    }
}
