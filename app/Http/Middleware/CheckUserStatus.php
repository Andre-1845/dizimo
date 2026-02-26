<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        /**
         * 🔑 REGRA 1
         * Se o e-mail AINDA NÃO foi verificado,
         * NÃO bloqueia pelo status.
         * Deixa o Laravel cuidar da verificação.
         */
        if (!$user->hasVerifiedEmail()) {
            return $next($request);
        }

        /**
         * 🔑 REGRA 2
         * A partir daqui, o e-mail JÁ foi verificado.
         */

        // Usuário pendente
        if ($user->status_id == 1) {
            Auth::logout();

            return redirect()
                ->route('login')
                ->with('warning', 'Seu cadastro está pendente de ativação pelo administrador.');
        }

        // Usuário suspenso
        if ($user->status_id == 3) {
            Auth::logout();

            return redirect()
                ->route('login')
                ->with('error', 'Seu acesso está suspenso. Entre em contato com o administrador.');
        }

        return $next($request);
    }
}
