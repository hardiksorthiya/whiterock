<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title',
        'description',
        'button_text',
        'button_url',
        'icon',
        'background_image',
        'is_active',
    ];

    /**
     * Normalize stored URL for use in href (supports absolute, mailto, tel, #, and site-relative paths).
     */
    public function getButtonHrefAttribute(): ?string
    {
        $u = $this->button_url !== null ? trim($this->button_url) : '';

        return $u !== '' ? $this->normalizeHref($u) : null;
    }

    protected function normalizeHref(string $u): string
    {
        if (preg_match('#^(https?:)?//#i', $u)
            || str_starts_with($u, 'mailto:')
            || str_starts_with($u, 'tel:')
            || str_starts_with($u, '#')
            || str_starts_with($u, '/')) {
            return $u;
        }

        return '/'.ltrim($u, '/');
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
