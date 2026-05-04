<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerApplication extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'years_experience',
        'education',
        'position',
        'hire_why',
        'cv_path',
    ];
}
