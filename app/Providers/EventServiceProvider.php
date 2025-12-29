<?php

namespace App\Providers;

use App\Listeners\ActivateUserAfterEmailVerification;
use Illuminate\Auth\Events\Verified;
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
    ];
}
