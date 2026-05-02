<?php

namespace App\Models;

use App\Models\CatalogueCategory;
use Illuminate\Database\Eloquent\Model;

class Catalogue extends Model
{
    protected $fillable = ['name', 'featured_image', 'pdf', 'category_id', 'is_active'];

    public function category()
    {
        return $this->belongsTo(CatalogueCategory::class, 'category_id');
    }

    public function downloads()
    {
        return $this->hasMany(CatalogueDownload::class);
    }
}
