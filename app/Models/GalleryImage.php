<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = ['category_id', 'image'];

    public function category()
    {
        return $this->belongsTo(GalleryCategory::class, 'category_id');
    }
}
