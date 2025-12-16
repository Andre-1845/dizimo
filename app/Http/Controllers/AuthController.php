<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRegisterUserRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Member;
use App\Models\User;
use Exception;
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

    public function loginProcess(LoginRequest $request)
    {
        try {
            $auhenticated = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
            if (!$auhenticated) {
                Log::notice('Erro de login.', ['email' => $request->email]);

                return back()->withInput()->with('error', 'Usuário ou senha incorretos');
            }
            Log::info('Login', ['action_user_id' => Auth::id()]);

            return redirect()->route('members.dashboard')->with('success', 'Usuário ' .  $request->user()->name . ' LOGADO com sucesso!');
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
                'name'    => $user->name,
                'email'   => $user->email,
                'active'  => true,
            ]);

            DB::commit();

            Log::info('Usuário e membro cadastrados', ['user_id' => $user->id]);

            return redirect()
                ->route('login')
                ->with('success', 'Cadastro realizado com sucesso!');
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
