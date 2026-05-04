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
        'hero_image',
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

    /**
     * Public URL for the page top banner image.
     */
    public function heroImageUrl(): string
    {
        if (! empty($this->hero_image)) {
            return asset('storage/'.$this->hero_image);
        }

        return asset('frontend/images/about-banner.jpg');
    }
}
