<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberTitheValue extends Model
{
    protected $fillable = [
        'member_id',
        'value',
        'start_date',
        'user_id',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
