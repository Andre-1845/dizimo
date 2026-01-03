<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function show()
    {
        /** @var User $user */
        $user = Auth::user()->load('member');

        return view('profile.show', ['user' => $user, 'menu' => 'profile']);
    }

    public function edit()
    {
        $user = Auth::user()->load('member');

        return view('profile.edit', ['user' => $user, 'menu' => 'profile']);
    }

    public function update(ProfileUpdateRequest $request)
    {

        $user = Auth::user();


        // DB::transaction(function () use ($user, $request) {

        //     // Atualiza USERS
        //     $user->update([
        //         'name'  => $request->name,
        //         'email' => $request->email,
        //     ]);

        //     // Atualiza MEMBERS (se existir)
        //     if ($user->member) {
        //         $user->member->update([
        //             'name'  => $request->name,
        //             'phone' => $request->phone,
        //         ]);
        //     }
        // });

        DB::transaction(function () use ($request, $user) {
            // Atualiza USER
            $user->update([
                'name'  => $request->user_name,
                'email' => $request->email,
            ]);

            if ($user->member && filled('member_name')) {
                $user->member->update([
                    'name'  => $request->member_name,
                    'phone' => $request->phone,
                ]);
            }
        });


        Log::info('Perfil editado', [
            'action_user_id' => $user->id
        ]);

        return redirect()
            ->route('profile.show')
            ->with('success', 'Perfil editado com sucesso!');
    }

    public function editPassword()
    {
        return view('profile.edit_password', [
            'user' => Auth::user(),
            'menu' => 'profile'
        ]);
    }

    public function updatePassword(PasswordRequest $request)
    {
        $user = Auth::user();

        $user->update([
            'password' => $request->password, // cast hashed já resolve
        ]);

        Log::info('Senha (perfil) alterada', [
            'action_user_id' => $user->id
        ]);

        return redirect()
            ->route('profile.show')
            ->with('success', 'Senha alterada com sucesso!');
    }




    // ANTIGO CODIGO
    // public function show()
    // {
    //     $user = User::where('id', Auth::id())->First();

    //     return view('profile.show', ['user' => $user]);
    // }

    // public function edit()
    // {
    //     $user = User::where('id', Auth::id())->First();

    //     return view('profile.edit', ['user' => $user]);
    // }

    // public function update(ProfileUpdateRequest $request)
    // {
    //     $user = User::where('id', Auth::id())->First();
    //     $user->update([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //     ]);
    //     // Redireciona o usuario e envia mensagem de sucesso
    //     Log::info('Perfil editado', ['action_user_id' => Auth::id()]);
    //     return redirect()->route('profile.show', ['user' =>  $user])->with('success', 'Perfil editado com sucesso!');
    // }

    // public function editPassword()
    // {
    //     $user = User::where('id', Auth::id())->First();
    //     return view('profile.edit_password', ['user' => $user]);
    // }

    // public function updatePassword(PasswordRequest $request)
    // {
    //     // Validacao da senha enviada
    //     // $request->validate([
    //     //     'password' => 'required|confirmed|min:6',
    //     // ]);
    //     $user = Auth::user();
    //     $user->update([
    //         'password' => $request->password,

    //     ]);
    //     // Redireciona o usuario e envia mensagem de sucesso

    //     Log::info('Senha (perfil) alterada', ['action_user_id' => Auth::id()]);

    //     return redirect()->route('profile.show', ['perfil' => $user])->with('success', 'Senha (perfil) editada com sucesso!');
    // }
}
