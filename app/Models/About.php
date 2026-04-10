<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = [
        'founder_name',
        'founder_designation',
        'founder_description',
        'founder_image',
        'about_image',
        'description',
        'mission',
        'vision',
        'values',
    ];
}
