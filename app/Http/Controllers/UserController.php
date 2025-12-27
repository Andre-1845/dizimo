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
use PhpParser\Node\Stmt\TryCatch;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // Carrega a view
    public function index(Request $request)
    {
        // $users = User::orderBy('name', 'asc')->paginate(10);
        // $users = User::with('member')
        //     ->when(
        //         $request->filled('name'),
        //         fn($query) =>
        //         $query->whereLike('name', '%' . $request->name . '%')
        //     )
        //     ->when(
        //         $request->filled('email'),
        //         fn($query) =>
        //         $query->whereLike('email', '%' . $request->email . '%')
        //     )
        //     ->when(
        //         $request->filled('start_date_registration'),
        //         fn($query) =>
        //         $query->where('created_at', '>=', $request->start_date_registration)
        //     )
        //     ->when(
        //         $request->filled('end_date_registration'),
        //         fn($query) =>
        //         $query->where('created_at', '<=', $request->end_date_registration)
        //     )
        //     ->orderBy('name', 'asc')
        //     ->paginate(10)
        //     ->withQueryString();

        // return view('users.index', [
        //     'menu' => 'users',
        //     'users' => $users,
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'start_date_registration' => $request->start_date_registration,
        //     'end_date_registration' => $request->end_date_registration,
        // ]);

        // Nova abordagem


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

    // public function list(User $user)
    // {
    //     // dd($user);
    //     $users = User::orderBy('name', 'asc')
    //         ->where('status_id', $user->id);
    //     // ->paginate(3);

    //     return view('users.index', ['users' => $users]);
    // }

    public function list(Status $status)
    {
        $users = User::where('status_id', $status->id)
            ->orderBy('name', 'asc')
            ->paginate(10);

        return view('users.index', ['users' => $users, 'menu' => 'users']);
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
        $roles = Role::pluck('name')->all();

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

        $user->delete();
        return redirect()->route('users.index', ['menu' => 'users'])->with('success', 'Usuário apagado!');
    }
}
