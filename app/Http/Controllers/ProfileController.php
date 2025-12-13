<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    //
    public function show()
    {
        $user = User::where('id', Auth::id())->First();

        return view('profile.show', ['user' => $user]);
    }

    public function edit()
    {
        $user = User::where('id', Auth::id())->First();

        return view('profile.edit', ['user' => $user]);
    }

    public function update(UserRequest $request)
    {
        $user = User::where('id', Auth::id())->First();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        // Redireciona o usuario e envia mensagem de sucesso
        Log::info('Perfil editado', ['action_user_id' => Auth::id()]);
        return redirect()->route('profile.show', ['user' =>  $user])->with('success', 'Perfil editado com sucesso!');
    }

    public function editPassword()
    {
        $user = User::where('id', Auth::id())->First();
        return view('profile.edit_password', ['user' => $user]);
    }

    public function updatePassword(PasswordRequest $request)
    {
        // Validacao da senha enviada
        // $request->validate([
        //     'password' => 'required|confirmed|min:6',
        // ]);
        $user = Auth::user();
        $user->update([
            'password' => $request->password,

        ]);
        // Redireciona o usuario e envia mensagem de sucesso

        Log::info('Senha (perfil) alterada', ['action_user_id' => Auth::id()]);

        return redirect()->route('profile.show', ['perfil' => $user])->with('success', 'Senha (perfil) editada com sucesso!');
    }
}
