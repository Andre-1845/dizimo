<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    //
    public function index()
    {
        $roles = Role::orderBy('name', 'ASC')->paginate(5);

        return view('roles.index', ['menu' => 'roles', 'roles' => $roles]);
    }

    public function create()
    {
        return view('roles.create', ['menu' => 'roles']);
    }

    public function store(Request $request)
    {
        try {

            $role = Role::create([
                'name' => $request->name,
                'guard_name' => $request->guard_name,
            ]);

            // Permissoes atribuidas ao novo papel
            $permissions = [
                'dashboard',
                'show-profile',
                'edit-profile',
                'edit-profile-password',
            ];

            // Atribuir permissoes ao papel
            $role->givePermissionTo($permissions);

            Log::info('Papel cadastrado', ['role_id' => $role->id, 'action_user_id' => Auth::id()]);
            return redirect()->route('roles.index')->with('success', 'Papel cadastrado com sucesso.');
        } catch (Exception $e) {
            Log::notice($e->getMessage());
            // redireciona e envia mensagem de erro
            return back()->withInput()->with('error', 'Papel NÃO cadastrado !');
        }
    }

    public function show(Role $role)
    {
        return view('roles.show', ['menu' => 'roles', 'role' => $role]);
    }

    public function edit(Role $role)
    {

        return view('roles.edit', ['menu' => 'roles', 'role' => $role]);
    }

    public function update(Request $request, Role $role)
    {
        //
        $role->update([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
        ]);
        // Salva o LOG da operação
        Log::info('Papel editado', ['action_user_id' => Auth::id()]);

        // Redireciona o usuario e envia mensagem de sucesso
        return redirect()->route('roles.show', ['menu' => 'roles', 'role' => $role->id])->with('success', 'Papel editado com sucesso!');
    }

    public function destroy(Role $role)
    {
        //
        $role->delete();
        return redirect()->route('roles.index', ['menu' => 'roles'])->with('success', 'Papael apagado!');
    }
}
