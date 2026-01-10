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
        'schedule_link',
        'order',
        'active',
    ];
}
