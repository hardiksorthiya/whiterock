<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CatalogueDownload extends Model
{
    protected $fillable = [
        'catalogue_id',
        'name',
        'email',
        'phone',
        'city',
        'ip_address',
    ];

    public function catalogue(): BelongsTo
    {
        return $this->belongsTo(Catalogue::class);
    }
}
