<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\ResetPassword;


class InviteResetPassword extends ResetPassword
{
    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->email,
        ], false));

        return (new MailMessage)
            ->subject('Convite para acessar o Sistema da Capelania N Sra das Graças')
            ->greeting('Olá!')
            ->line('Você foi convidado(a) para acessar o sistema da Capelania N Sra das Graças (AMAN).')
            ->line('Para definir sua senha e acessar o sistema, clique no botão abaixo:')
            ->action('Definir minha senha', $url)
            ->line('Se você não esperava este convite, pode ignorar este e-mail.');
    }
}
