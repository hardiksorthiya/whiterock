<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'layout',
        'slug',
        'description',
        'faq_items',
        'meta_title',
        'meta_description',
        'keywords',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'faq_items' => 'array',
            'is_active' => 'boolean',
        ];
    }
}
