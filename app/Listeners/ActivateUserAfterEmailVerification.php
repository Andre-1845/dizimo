<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;



class ActivateUserAfterEmailVerification
{
    /**
     * Handle the event.
     */
    public function handle(Verified $event)
    {
        $user = $event->user;

        if ($user->status_id === 1) { // PENDENTE
            $user->update(['status_id' => 2]); // ATIVO
        }
    }
}
