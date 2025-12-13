<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    // Listar Status
    public function index()
    {
        $status = Status::orderBy('name', 'asc')->get();
        return view('statuses.index', ['menu' => 'statuses', 'status' => $status]);
    }

    public function create()
    {
        return view('statuses.create', ['menu' => 'statuses']);
    }

    public function store(Request $request)
    {
        Status::create([
            'name' => $request->name
        ]);

        return redirect()->route('statuses.index', ['menu' => 'statuses'])->with('success', 'Status cadastrado com sucesso!');
    }
}
