<?php

namespace App\Models;

use App\Helpers\StringHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SitePerson extends Model
{
    protected $table = 'site_people';

    protected $fillable = [
        'name',
        'role',
        'description',
        'photo_path',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::saving(function ($person) {
            if (filled($person->name)) {
                $person->name = StringHelper::formatName($person->name);
                $person->role = ucfirst(mb_strtolower($person->role));
            }
        });
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if (!$this->photo_path) {
            return null;
        }

        return Storage::disk('s3')->url($this->photo_path);
    }
}