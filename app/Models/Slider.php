<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'image_mobile',
        'is_active',
        'show_button',
        'button_text',
        'button_link',
        'show_video',
        'video_link',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'show_button' => 'boolean',
            'show_video' => 'boolean',
        ];
    }
}
