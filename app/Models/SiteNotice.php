<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteNotice extends Model
{
    //
    use HasFactory;

    protected $table = 'site_notices';

    protected $fillable = [
        'title',
        'content',
        'starts_at',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'starts_at'  => 'date',
        'expires_at' => 'date',
        'is_active'  => 'boolean',
    ];

    /**
     * Scope: avisos visíveis no site
     */
    public function scopeVisible($query)
    {
        return $query
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            });
    }
}
