<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */


    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Usuário pendente
        if ($user->status_id == 1) { // PENDENTE
            auth()->logout();

            return redirect()
                ->route('login')
                ->with('warning', 'Seu e-mail ainda não foi confirmado. Verifique sua caixa de entrada.');
        }

        // Usuário suspenso
        if ($user->status_id == 3) { // SUSPENSO
            auth()->logout();

            return redirect()
                ->route('login')
                ->with('error', 'Seu acesso está suspenso. Entre em contato com o administrador.');
        }

        return $next($request);
    }
}
