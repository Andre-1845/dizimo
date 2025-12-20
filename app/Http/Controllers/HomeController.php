<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Carrega a view HOME
    // public function index()
    // {
    //     return view('home.index');
    // }

    public function index()
    {
        if (!auth()->check()) {
            return view('home.index'); // landing pública
        }

        $user = auth()->user();

        if ($user->can('view-dashboard-admin')) {
            return redirect()->route('dashboard.index');
        }

        if ($user->can('view-dashboard-dizimo')) {
            return redirect()->route('dashboard.dizimo');
        }

        if ($user->can('view-dashboard-member') && $user->member) {
            return redirect()->route('dashboard.member');
        }

        // fallback seguro
        return redirect()->route('profile.show');
    }
}
