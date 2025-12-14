<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'active',
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
