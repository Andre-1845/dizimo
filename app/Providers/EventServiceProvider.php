<?php

namespace App\Providers;

use App\Listeners\ActivateUserAfterEmailVerification;
use App\Listeners\LogoutAfterPasswordReset;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    protected $listen = [
        Verified::class => [
            ActivateUserAfterEmailVerification::class,
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        PasswordReset::class => [
            LogoutAfterPasswordReset::class,
        ],
    ];
}
