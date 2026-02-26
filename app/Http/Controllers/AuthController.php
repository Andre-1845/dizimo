<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRegisterUserRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Church;
use App\Models\Member;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
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
        // Se já estiver logado, não mostra login
        if (Auth::check()) {
            $user = Auth::user();
            // Admin
            if ($user->can('dashboard.admin')) {
                return redirect()->route('dashboard.admin');
            }

            // Tesouraria / dízimo
            if ($user->can('dashboard.treasury')) {
                return redirect()->route('dashboard.treasury');
            }

            // Membro
            if ($user->can('dashboard.member')) {
                return redirect()->route('dashboard.member');
            }

            // Se não tem nenhum dashboard específico, verifica permissões de módulo
            if (
                $user->can('users.access') || $user->can('members.access') ||
                $user->can('donations.access') || $user->can('reports.access')
            ) {
                return redirect()->route('dashboard.admin');
            }

            // Fallback seguro
            return redirect()->route('site.home');
        }

        return view('auth.login');
    }

    public function loginProcess(LoginRequest $request)
    {

        if (!Auth::attempt($request->only('email', 'password'))) {
            Log::notice('Erro de login.', ['email' => $request->email]);
            return back()->withInput()->with('error', 'Usuário ou senha incorretos');
        }

        // Verificar se o usuário está ativo
        $user = Auth::user();

        if ($user->roles->isEmpty()) {
            Auth::logout();
            return back()->withErrors('Usuário sem papel atribuído.');
        }

        Log::info('Login realizado', [
            'user_id' => $user->id,
            'email' => $user->email,
            'roles' => $user->getRoleNames()->toArray()
        ]);

        // Redirecionar com base nas permissões (mesma lógica do método index)
        if ($user->can('dashboard.admin')) {
            return redirect()->intended(route('dashboard.admin'));
        } elseif ($user->can('dashboard.treasury')) {
            return redirect()->intended(route('dashboard.treasury'));
        } elseif ($user->can('dashboard.member')) {
            return redirect()->intended(route('dashboard.member'));
        }

        return redirect()->intended(route('profile.show'));
    }

    // LOGOUT

    public function logout(Request $request)
    {
        Log::notice('Logout', ['action_user_id' => Auth::id()]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('site.home')
            ->with('success', 'Logout realizado com sucesso!');
    }

    public function create()
    {
        $churches = Church::all();

        return view('auth.register', compact('churches'));
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
            if (Role::where('name', 'membro')->exists()) {
                $user->assignRole('membro');
            }

            // Criar MEMBER automaticamente

            Member::create([
                'user_id' => $user->id,
                'name'    => $request->name,
                'active'  => true,
                'church_id' => $request->church_id,

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