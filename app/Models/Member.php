<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'active',
        'monthly_tithe', // valor previsto
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
