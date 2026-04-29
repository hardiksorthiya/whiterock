<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductApplication extends Model
{
    protected $fillable = [
        'name',
        'gallery_category_id',
        'gallery_category_ids',
    ];

    protected $casts = [
        'gallery_category_ids' => 'array',
    ];

    public function galleryCategory(): BelongsTo
    {
        return $this->belongsTo(GalleryCategory::class, 'gallery_category_id');
    }
}

