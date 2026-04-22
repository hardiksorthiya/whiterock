<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $casts = [
        'is_featured' => 'boolean',
    ];

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'short_description',
        'long_description',
        'meta_title',
        'meta_description',
        'keywords',
        'is_active',
        'is_featured',
        'image',
        'category_id',
        'featured_image',
        'catalogue_path',
        'available_size',
        'emboss_height',
        'pattern_size',
        'installation',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductCategory::class,
            'product_product_category',
            'product_id',
            'product_category_id'
        )->withTimestamps();
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order')->orderBy('id');
    }
}
