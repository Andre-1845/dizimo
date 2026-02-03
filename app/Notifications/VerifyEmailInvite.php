<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailInvite extends VerifyEmail
{
    /**
     * Constrói o e-mail de convite + verificação
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject('Convite para acesso ao sistema')
            ->greeting('Olá!')
            ->line('Você foi cadastrado como membro e recebeu acesso ao sistema.')
            ->line('Para ativar seu acesso, confirme seu endereço de e-mail clicando no botão abaixo.')
            ->action('Confirmar e ativar acesso', $url)
            ->line('Se você não esperava este convite, pode ignorar este e-mail.');
    }
}
