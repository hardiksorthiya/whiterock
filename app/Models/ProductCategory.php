<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductCategory extends Model
{
    protected $fillable = ['name', 'slug', 'image', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'product_product_category',
            'product_category_id',
            'product_id'
        )->withTimestamps();
    }

    /**
     * First active category by id (used when product form sends no categories).
     */
    public static function getDefaultId(): ?int
    {
        return self::query()->where('is_active', true)->orderBy('id')->value('id');
    }
}
