<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SiteEvent extends Model
{
    protected $fillable = [
        'title',
        'event_date',
        'time',
        'description',
        'is_active',
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_active'  => 'boolean',
    ];

    // Scope útil
    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }
}
