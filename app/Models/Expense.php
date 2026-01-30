<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
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
}
