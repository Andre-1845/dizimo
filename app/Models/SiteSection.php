<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSection extends Model
{
    protected $fillable = [
        'key',
        'title',
        'subtitle',
        'content',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Imagens da seção
    public function images()
    {
        return $this->hasMany(SiteImage::class, 'section_key', 'key')
            ->orderBy('order');
    }
}
