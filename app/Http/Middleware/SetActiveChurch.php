<?php

namespace App\Http\Middleware;

use App\Models\Church;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetActiveChurch
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {

            if (!session()->has('view_church_id')) {

                $user = auth()->user();

                // Se usuário tem member
                if ($user->member && $user->member->church_id) {

                    session([
                        'view_church_id' => $user->member->church_id
                    ]);
                } else {

                    // 👇 fallback seguro
                    $firstChurch = Church::first();

                    if ($firstChurch) {
                        session([
                            'view_church_id' => $firstChurch->id
                        ]);
                    }
                }
            }
        }

        return $next($request);
    }
}
