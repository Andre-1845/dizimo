<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SiteImage extends Model
{
    protected $fillable = [
        'section_key',
        'image_path',
        'caption',
        'order',
    ];

    public function section()
    {
        return $this->belongsTo(
            SiteSection::class,
            'section_key',
            'key'
        );
    }

    public function getImageUrlAttribute()
    {
        return Storage::disk('s3')->url($this->image_path);
    }
}