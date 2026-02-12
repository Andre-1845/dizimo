<?php

namespace App\Providers;

use App\Models\SiteSetting;
use App\Services\EmailTemplateService;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {

        config([
            'app.name' => SiteSetting::get(
                'app_name',
                config('app.name')
            ),
        ]);
        // ==========================
        // VIEW GLOBAL DATA
        // ==========================

        view()->composer('*', function ($view) {
            $view->with('siteLogo', SiteSetting::get('site_logo'));
            $view->with('appName', SiteSetting::get('app_name', config('app.name')));
        });

        // ==========================
        // SUPER ADMIN PERMISSIONS
        // ==========================

        Gate::before(function ($user, $ability) {
            if (!$user) {
                return null;
            }
            return $user->hasRole('superadmin') ? true : null;
        });

        Paginator::useTailwind();

        // ==========================
        // PERSONALIZAÇÃO DE EMAIL
        // ==========================

        config([
            'mail.from.name' => SiteSetting::get(
                'mail_from_name',
                config('mail.from.name')
            ),
        ]);

        $useDefault = SiteSetting::get('use_default_email_templates', true);

        if (!$useDefault) {

            $emailService = new EmailTemplateService();

            VerifyEmail::toMailUsing(function ($notifiable, $url) use ($emailService) {

                $template = $emailService->getVerificationEmail();

                return (new MailMessage)
                    ->subject($template['subject'])
                    ->line($template['body'])
                    ->action('Confirmar Email', $url);
            });

            ResetPassword::toMailUsing(function ($notifiable, $token) use ($emailService) {

                $url = url(route('password.reset', [
                    'token' => $token,
                    'email' => $notifiable->getEmailForPasswordReset(),
                ], false));

                $template = $emailService->getPasswordResetEmail();

                return (new MailMessage)
                    ->subject($template['subject'])
                    ->line($template['body'])
                    ->action('Redefinir Senha', $url);
            });
        }
    }
}
