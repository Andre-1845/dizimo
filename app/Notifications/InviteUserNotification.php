<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class InviteUserNotification extends VerifyEmail
{
    public function toMail($notifiable)
    {
        $verifyUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addDays(7),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

        $resetUrl = route('password.request');

        return (new MailMessage)
            ->subject('Você foi convidado para acessar o sistema da capelania')
            ->greeting('Olá!')
            ->line('Uma conta foi criada para você no sistema da capelania.')
            ->line('Para acessar, confirme seu e-mail e crie sua senha.')
            ->action('Confirmar e definir senha', $verifyUrl)
            ->line('Após confirmar o e-mail, clique em "Esqueci minha senha" para definir uma nova senha.')
            ->line('Se você não esperava este convite, pode ignorar este e-mail.');
    }
}
