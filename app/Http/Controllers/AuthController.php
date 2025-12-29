<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRegisterUserRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Member;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    //
    public function index()
    {
        return view('auth.login');
    }

    // public function processlogin(LoginRequest $request)
    // {
    //     try {
    //         $auhenticated = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
    //         if (!$auhenticated) {
    //             Log::notice('Erro de login.', ['email' => $request->email]);

    //             return back()->withInput()->with('error', 'Usuário ou senha incorretos');
    //         }
    //         Log::info('Login', ['action_user_id' => Auth::id()]);

    //         $user = Auth::user();

    //         if ($user->hasRole('Membro')) {
    //             return redirect()
    //                 ->route('dashboard.member')
    //                 ->with('success', 'Bem-vindo(a), ' . $user->name . '!');
    //         }

    //         // Admin, SuperAdmin, Tesoureiro etc
    //         return redirect()
    //             ->route('dashboard')
    //             ->with('success', 'Bem-vindo(a), ' . $user->name . '!');
    //     } catch (Exception $e) {
    //         Log::notice('Erro de login.', ['error' => $e->getMessage()]);

    //         return back()->withInput()->with('error', 'Usuário ou senha incorretos');
    //     }
    //     // return view('login.index');
    // }

    public function loginProcess(LoginRequest $request)
    {

        if (!Auth::attempt($request->only('email', 'password'))) {
            Log::notice('Erro de login.', ['email' => $request->email]);
            return back()->withInput()->with('error', 'Usuário ou senha incorretos');
        }
        // VALIDACAO DE STATUS DO USUARIO

        // if ($user->status_id !== 2) {
        //     Auth::logout();

        //     return back()->withErrors([
        //         'email' => 'Seu cadastro ainda não está ativo. Verifique seu e-mail.'
        //     ]);
        // }

        Log::info('Login', ['action_user_id' => Auth::id()]);

        // NÃO decida dashboard aqui
        return redirect()->intended('/');
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
        DB::beginTransaction();

        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Role padrão: MEMBRO
            if (Role::where('name', 'Membro')->exists()) {
                $user->assignRole('Membro');
            }

            // Criar MEMBER automaticamente
            Member::create([
                'user_id' => $user->id,
                'name'    => $request->name,
                'active'  => true,
            ]);


            // 🔥 DISPARA O EMAIL DE VERIFICAÇÃO
            event(new Registered($user));

            DB::commit();

            Log::info('Usuário e membro cadastrados', ['user_id' => $user->id]);

            return redirect()
                ->route('login')
                ->with('success', 'Cadastro realizado com sucesso! Um e-mail de ativação foi enviado para o endereço cadastrado. Ative o e-mail antes de acessar o sistema.');
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Erro ao cadastrar usuário/membro', [
                'error' => $e->getMessage()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Erro ao realizar cadastro.');
        }
    }
}
