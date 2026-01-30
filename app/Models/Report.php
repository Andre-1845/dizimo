<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Report extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'available_until',
        'is_active',
        'user_id',
    ];

    protected $casts = [
        'available_until' => 'date',
        'is_active' => 'boolean',
        'created_at' => 'datetime:d/m/Y H:i',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('available_until')
                    ->orWhere('available_until', '>=', now());
            });
    }

    public function getFileUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    public function getStatusBadgeAttribute()
    {
        if (!$this->is_active) {
            return '<span class="badge bg-secondary">Inativo</span>';
        }

        if ($this->available_until && $this->available_until < now()) {
            return '<span class="badge bg-warning">Expirado</span>';
        }

        return '<span class="badge bg-success">Ativo</span>';
    }
}
