<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    //Carrega a view
    public function index()
    {
        return view('modules.index');
    }
}
