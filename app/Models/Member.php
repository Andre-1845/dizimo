<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\StringHelper;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
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



    protected static function booted()
    {
        static::saving(function ($member) {
            if ($member->name) {
                $member->name = StringHelper::formatName($member->name);
            }
        });
    }
}
