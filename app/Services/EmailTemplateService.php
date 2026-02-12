<?php

namespace App\Services;

use App\Models\SiteSetting;

class EmailTemplateService
{
    public function getVerificationEmail(): array
    {
        return [
            'subject' => SiteSetting::get(
                'email_verification_subject',
                'Confirme seu email'
            ),

            'body' => SiteSetting::get(
                'email_verification_body',
                'Obrigado por se cadastrar. Clique no botão abaixo para confirmar seu email.'
            ),
        ];
    }

    public function getPasswordResetEmail(): array
    {
        return [
            'subject' => SiteSetting::get(
                'password_reset_subject',
                'Redefinição de senha'
            ),

            'body' => SiteSetting::get(
                'password_reset_body',
                'Recebemos uma solicitação para redefinir sua senha. Clique no botão abaixo para continuar.'
            ),
        ];
    }
}
