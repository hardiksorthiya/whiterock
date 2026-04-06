<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'logo_path',
        'favicon_path',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'whatsapp_url',
        'phone',
        'email',
        'contact_locations',
        'footer_text',
        'google_api_key',
        'google_place_id',
    ];

    protected function casts(): array
    {
        return [
            'contact_locations' => 'array',
        ];
    }

    /**
     * Single site settings row (singleton).
     */
    public static function site(): self
    {
        $row = static::query()->first();
        if ($row) {
            return $row;
        }

        return static::query()->create(['contact_locations' => []]);
    }
}
