<?php

namespace App\Models;

use App\Models\Traits\BelongsToChurch;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use BelongsToChurch;
    //
    protected $fillable = [
        'user_id',
        'category_id',
        'payment_method_id',
        'amount',
        'expense_date',
        'description',
        'notes',
        'receipt_path',
        'is_approved',
        'approved_at',
        'approved_by',
        'church_id',
    ];

    protected $casts = [
        'expense_date' => 'date',
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    public function getIsConfirmedAttribute(): bool
    {
        return $this->is_approved;
    }

    public function getApprovalInfoAttribute(): string
    {
        if (!$this->approved_at || !$this->approver) {
            return '-';
        }

        return $this->approved_at->format('d/m/Y H:i')
            . ' – '
            . $this->approver->name;
    }
}
