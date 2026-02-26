<?php

namespace App\Models;

use App\Models\Traits\BelongsToChurch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use SoftDeletes;
    use BelongsToChurch;

    protected $fillable = [
        'user_id',
        'member_id',
        'category_id',
        'payment_method_id',
        'donor_name',
        'amount',
        'donation_date',
        'notes',
        'receipt_path',
        'is_confirmed',
        'confirmed_at',
        'confirmed_by',
        'church_id',
    ];

    protected $casts = [
        'donation_date' => 'date',
        'is_confirmed' => 'boolean',
        'confirmed_at' => 'datetime',
    ];

    /**
     * Quem registrou a doação (admin / tesoureiro)
     * Pode estar soft deleted
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }


    /**
     * Quem contribuiu (membro)
     * Pode estar inativo ou soft deleted
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Categoria financeira (dízimo, oferta, etc.)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Forma de pagamento
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function getDisplayDonorAttribute(): string
    {
        if ($this->member) {
            return $this->member->name;
        }

        return $this->donor_name ?: 'Administração';
    }

    public function scopeConfirmed($query)
    {
        return $query->where('is_confirmed', true);
    }

    public static function totalConfirmed(array $filters = [])
    {
        return self::confirmed()
            ->when($filters['user_id'] ?? null, fn($q, $v) => $q->where('user_id', $v))
            ->when($filters['month'] ?? null, fn($q, $v) => $q->whereMonth('donation_date', $v))
            ->when($filters['year'] ?? null, fn($q, $v) => $q->whereYear('donation_date', $v))
            ->sum('amount');
    }
}
