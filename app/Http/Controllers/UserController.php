<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserRequest;
use App\Models\Member;
use App\Models\Status;
use App\Models\User;
use FFI\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function __construct()
    {
        // Protege todas as ações do controller
        $this->middleware('permission:users.view')->only(['index', 'show']);
        $this->middleware('permission:users.create')->only(['create', 'store']);
        $this->middleware('permission:users.edit')->only(['edit', 'update']);
        $this->middleware('permission:users.delete')->only(['destroy']);
        $this->middleware('permission:users.reset-password')->only(['editPassword', 'updatePassword']);
    }
    // Carrega a view
    public function index(Request $request)
    {
        $users = User::query()
            ->when(
                $request->filled('name'),
                fn($q) => $q->where('name', 'like', "%{$request->name}%")
            )
            ->when(
                $request->filled('email'),
                fn($q) => $q->where('email', 'like', "%{$request->email}%")
            )
            ->when(
                $request->filled('status'),
                fn($q) => $q->where('status_id', $request->status)
            )
            ->when(
                $request->filled('role'),
                fn($q) => $q->role($request->role)
            )
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('users.index', [
            'users' => $users,
            'roles' => Role::orderBy('name')->get(),
            'menu' => 'users',
        ]);
    }

    public function create()
    {
        // Recuperar os papeis do BD
        $roles = Role::pluck('name')->all();
        // Carregar a VIEW
        return view('users.create', ['roles' => $roles, 'menu' => 'users']);
    }

    public function store(UserRequest $request)
    {
        try {

            DB::beginTransaction();

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
                'active'  => true,
            ]);

            $user->sendEmailVerificationNotification();

            DB::commit();


            //Verificar se veio algum papel selecionado
            if ($request->filled('roles')) {
                $validRoles = Role::whereIn('name', $request->roles)->pluck('name')->toArray();
                $user->syncRoles($validRoles); // ou assignRole() se for um papel só
            }

            Log::info('Usuário e membro cadastrados', ['user_id' => $user->id]);

            return redirect()->route('users.show', ['menu' => 'users', 'user' => $user->id])->with('success', 'Usuário cadastrado com sucesso!');
        } catch (Exception $e) {
            // redireciona e envia mensagem de erro
            return back()->withInput()->with('error', 'Usuário NÃO cadastrado !');
        }
    }

    public function show(User $user)
    {
        return view('users.show', ['user' => $user, 'menu' => 'users']);
    }


    public function edit(User $user)
    {
        // Recuperar os papeis existentes no BD
        // $roles = Role::pluck('name')->all();
        $currentUser = Auth::user();
        $roles = Role::query()

            //  Regra 1: quem NÃO é superadmin não vê superadmin
            ->when(
                !$currentUser->hasRole('superadmin'),
                fn($q) => $q->where('name', '!=', 'superadmin')
            )

            //  Regra 2: quem NÃO é superadmin NEM admin não vê admin
            ->when(
                !$currentUser->hasRole('superadmin') && !$currentUser->hasRole('admin'),
                fn($q) => $q->where('name', '!=', 'admin')
            )

            ->pluck('name')
            ->all();

        // Recuperar os papeis atribuidos ao USUARIO
        $userRoles = $user->roles->pluck('name')->toArray();

        // Recuperar os STATUS da tabela
        $statuses = Status::all(); // tabela que contém os status

        // Carregar e enviar DADOS para a VIEW
        return view('users.edit', [
            'menu' => 'users',
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles,
            'statuses' => $statuses
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status_id' => $request->status_id,
        ]);

        // Se houver PAPEIS enviados no REQUEST, ativa a sincronizacao de papeis do usuario
        if ($request->filled('roles')) {
            // Verifica quais papeis do REQUEST estao validos no BD
            $validRoles = Role::whereIn('name', $request->roles)->pluck('name')->toArray();
            // sincroniza APENAS o ARRAY com os papeis validos
            $user->syncRoles($validRoles); // ou assignRole() se for um papel só
        } else {
            $user->syncRoles([]); // remove todos os papeis PQ sincroniza uma ARRAY VAZIO
        }


        // Redireciona o usuario e envia mensagem de sucesso
        Log::info('User editado', ['action_user_id' => Auth::id()]);
        return redirect()->route('users.show', ['menu' => 'users', 'user' => $user->id])->with('success', 'Usuário editado com sucesso!');
    }

    public function editPassword(User $user)
    {
        return view('users.edit_password', ['user' => $user, 'menu' => 'users']);
    }

    public function updatePassword(PasswordRequest $request, User $user)
    {
        // Validacao da senha enviada
        // $request->validate([
        //     'password' => 'required|min:6',
        // ]);
        $user->update([
            'password' => $request->password,

        ]);
        // Redireciona o usuario e envia mensagem de sucesso

        Log::info('Senha alterada', ['action_user_id' => Auth::id()]);

        return redirect()->route('users.show', ['menu' => 'users', 'user' => $user->id])->with('success', 'Senha editada com sucesso!');
    }


    public function destroy(User $user)
    {
        // 1. Verifica auto-exclusão
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Você não pode excluir sua própria conta.');
        }

        // 2. Verifica se é o último superadmin (opcional)
        if ($user->hasRole('superadmin') && User::role('superadmin')->count() <= 1) {
            return back()->with('error', 'Não é possível excluir o único superadministrador do sistema.');
        }

        // 3. Autorização simples (sem policy)
        if (!Auth::user()->can('users.delete')) {
            abort(403, 'Acesso não autorizado.');
        }

        $user->delete();
        return redirect()->route('users.index', ['menu' => 'users'])->with('success', 'Usuário excluído!');
    }
}
