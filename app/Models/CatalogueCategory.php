<?php

namespace App\Models;

use App\Models\Catalogue;
use Illuminate\Database\Eloquent\Model;

class CatalogueCategory extends Model
{
    protected $fillable = ['name','slug'];

    public function catalogues()
    {
        return $this->hasMany(Catalogue::class, 'category_id');
    }
}
