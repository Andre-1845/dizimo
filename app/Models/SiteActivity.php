<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteActivity extends Model
{
    protected $fillable = [
        'name',
        'day',
        'time',
        'email',
        'phone',
        'schedule_link',
        'order',
        'active',
    ];
}
