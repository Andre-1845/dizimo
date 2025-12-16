<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'user_id',
        'member_id',
        'category_id',
        'payment_method_id',
        'amount',
        'donation_date',
        'notes',
        'receipt_path',
    ];

    protected $casts = [
        'donation_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
