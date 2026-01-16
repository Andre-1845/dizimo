<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // Carrega a view HOME
    // public function index()
    // {
    //     return view('home.index');
    // }

    public function index()
    {
        if (!Auth::check()) {
            return view('home.index'); // landing pública
        }

        $user = Auth::user();

        if ($user->can('dashboard.admin')) {
            return redirect()->route('dashboard.admin');
        }

        if ($user->can('dashboard.treasury')) {
            return redirect()->route('dashboard.treasury');
        }

        if ($user->can('dashboard.member') && $user->member) {
            return redirect()->route('dashboard.member');
        }

        // fallback seguro
        return redirect()->route('profile.show');
    }
}
