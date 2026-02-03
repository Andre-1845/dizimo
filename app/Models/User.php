<?php

namespace App\Models;

use App\Helpers\StringHelper;
use App\Notifications\VerifyEmailInvite;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'status_id',
        'password',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function member()
    {
        return $this->hasOne(Member::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    // ======================
    // SCOPES DE STATUS
    // ======================

    public function scopePending($query)
    {
        return $query->where('status_id', 1);
    }

    public function scopeActive($query)
    {
        return $query->where('status_id', 2);
    }

    public function scopeInactive($query)
    {
        return $query->where('status_id', 3);
    }



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted()
    {
        static::saving(function ($user) {
            if (filled($user->name)) {
                $user->name = StringHelper::formatName($user->name);
            }
        });
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailInvite());
    }
}
