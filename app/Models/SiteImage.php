<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteImage extends Model
{
    protected $fillable = [
        'section_key',
        'image_path',
        'caption',
        'order',
    ];
}
