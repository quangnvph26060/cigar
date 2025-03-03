<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_name',
        'logo',
        'icon',
        'hotline',
        'phone_number',
        'intro_title',
        'introduction',
        'address',
        'email',
        'copyright',
        'restriction_message',
        'adult_only_policy',

        'title',
        'seo_title',
        'seo_description',
        'seo_keywords'
    ];

    protected $casts = [
        'seo_keywords' => 'array'
    ];
}
