<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use SoftDeletes;

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
    ];

    protected $casts = [
        'donation_date' => 'date',
    ];

    /**
     * Quem registrou a doação (admin / tesoureiro)
     * Pode estar soft deleted
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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
}
