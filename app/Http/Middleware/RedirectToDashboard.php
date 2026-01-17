<?php
// app/Http/Middleware/RedirectToDashboard.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectToDashboard
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Se acessar a rota raiz / ou /dashboard e estiver autenticado
        if (($request->is('/') || $request->is('dashboard')) && Auth::check()) {
            $user = Auth::user();

            // 1. Admin, Superadmin, Tesoureiro, Secretário -> Dashboard Admin
            if ($user->hasAnyRole(['superadmin', 'admin', 'tesoureiro', 'secretario'])) {
                return redirect()->route('dashboard.admin');
            }

            // 2. Tesoureiro específico ou com permissão de dízimo -> Dashboard Tesouraria
            if ($user->hasRole('tesoureiro') || $user->can('dashboard.treasury')) {
                return redirect()->route('dashboard.treasury');
            }

            // 3. Padrão -> Dashboard Membro
            return redirect()->route('dashboard.member');
        }

        return $next($request);
    }
}
