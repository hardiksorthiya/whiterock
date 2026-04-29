<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'logo_path',
        'light_logo_path',
        'favicon_path',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'whatsapp_url',
        'phone',
        'email',
        'contact_address',
        'contact_map_iframe',
        'contact_locations',
        'footer_text',
        'footer_copyright_text',
        'contact_background_image_path',
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
