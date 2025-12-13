<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRegisterUserRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    //
    public function index()
    {
        return view('auth.login');
    }

    public function loginProcess(LoginRequest $request)
    {
        try {
            $auhenticated = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
            if (!$auhenticated) {
                Log::notice('Erro de login.', ['email' => $request->email]);

                return back()->withInput()->with('error', 'Usuário ou senha incorretos');
            }
            Log::info('Login', ['action_user_id' => Auth::id()]);

            return redirect()->route('dashboard.index')->with('success', 'Usuário ' .  $request->user()->name . ' LOGADO com sucesso!');
        } catch (Exception $e) {
            Log::notice('Erro de login.', ['error' => $e->getMessage()]);

            return back()->withInput()->with('error', 'Usuário ou senha incorretos');
        }
        // return view('login.index');
    }

    // LOGOUT

    public function logout()
    {
        Log::notice('Logout', ['action_user_id' => Auth::id()]);

        Auth::logout();

        return redirect()->route('login')->with('success', 'LOGOUT executado!!');
    }

    public function create()
    {
        return view('auth.register');
    }

    public function store(AuthRegisterUserRequest $request)
    {
        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            // Verificar se existe o ROLE ALUNO antes de atribuir a um novo cadastro
            if (Role::where('name', 'Aluno')->exists()) {
                $user->assignRole('Aluno');
            }
            Log::info('Usuario cadastrado', ['user_id' => $user->id]);

            return redirect()->route('login')->with('success', 'Usuário cadastrado com sucesso!');
        } catch (Exception $e) {
            // redireciona e envia mensagem de erro
            return back()->withInput()->with('error', 'Usuário NÃO cadastrado !');
        }
    }
}
