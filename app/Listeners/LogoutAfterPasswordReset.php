<?php

namespace App\Listeners;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;

class LogoutAfterPasswordReset
{
    /**
     * Handle the event.
     */
    public function handle(PasswordReset $event): void
    {
        // Garante que nenhuma sessão ativa seja reutilizada
        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();
    }
}
