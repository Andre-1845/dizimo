<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
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
