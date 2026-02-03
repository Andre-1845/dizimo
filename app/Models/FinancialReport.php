<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class FinancialReport extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'type',
        'reference_month',
        'published_at',
        'valid_until',
        'is_published',
        'published_by',
    ];

    protected $casts = [
        'reference_month' => 'date',
        'published_at'    => 'date',
        'valid_until'     => 'date',
        'is_published'    => 'boolean',
    ];

    /* =========================
     * Relacionamentos
     * ========================= */

    public function publisher()
    {
        return $this->belongsTo(User::class, 'published_by');
    }

    /* =========================
     * Scopes
     * ========================= */

    /**
     * Relatórios visíveis na Transparência
     */
    public function scopePublic(Builder $query): Builder
    {
        return $query
            ->where('is_published', true)
            ->whereDate('published_at', '<=', now())
            ->where(function ($q) {
                $q->whereNull('valid_until')
                    ->orWhereDate('valid_until', '>=', now());
            });
    }

    /**
     * Filtrar por tipo de relatório
     */
    public function scopeType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    /**
     * Filtrar por ano
     */
    public function scopeYear(Builder $query, int $year): Builder
    {
        return $query->whereYear('reference_month', $year);
    }

    /**
     * Filtrar por mês
     */
    public function scopeMonth(Builder $query, int $month): Builder
    {
        return $query->whereMonth('reference_month', $month);
    }

    /* =========================
     * Accessors
     * ========================= */

    /**
     * URL pública do arquivo
     */
    public function getFileUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }

    /**
     * Status legível (admin / view)
     */
    public function getStatusLabelAttribute(): string
    {
        if (! $this->is_published) {
            return 'Rascunho';
        }

        if ($this->valid_until && $this->valid_until->isPast()) {
            return 'Vencido';
        }

        return 'Publicado';
    }
}
