<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Carrega a view HOME
    public function index()
    {
        return view('home.index');
    }
}
