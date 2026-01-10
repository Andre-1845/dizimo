<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SitePerson extends Model
{
    protected $table = 'site_people';

    protected $fillable = [
        'name',
        'role',
        'description',
        'photo_path',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
