<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    // Carrega a view
    public function index(Role $role)
    {
        // dd($role);
        // verificar se o papel é super admin (nao permitir visualizacao)
        if ($role->name == 'Super Admin') {
            // Salvar LOG
            Log::info('A permissao do Super Admin nao pode ser acessada', ['role_id' => $role->id, 'action_user_id' => Auth::id()]);

            return redirect()->route('roles.index')->with('error', 'As permissoes do Super Admin nao estão disponíveis para consulta.');
        }
        // Recuperar as permissoes do papel no BD
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_id', $role->id)
            ->pluck('permission_id')
            ->all();

        // Recuperar TODAS as permissoes existentes no BD
        $permissions = Permission::orderBy('name')->get();

        // Salvar LOG
        Log::info('Listar permissoes do papel.', ['role_id' => $role->id, 'action_user_id' => Auth::id()]);

        return view('role-permissions.index', [
            'menu' => 'roles',
            'rolePermissions' => $rolePermissions,
            'permissions' => $permissions,
            'role' => $role,
        ]);
    }

    public function update(Role $role, Permission $permission)
    {
        //Capturar possiveis excecoes durante a execucao
        try {
            //Definir acao (bloquear ou liberar)
            $action = $role->permissions->contains($permission) ? 'bloquear' : 'liberar';

            // Liberar ou bloquear a permissao
            $role->{$action === 'bloquear' ? 'revokePermissionTo' : 'givePermissionTo'}($permission);
            //Salvar LOG
            Log::info(ucfirst($action) . ' permissao para o papel.', [
                'role_id' => $role->id,
                'permission_id' => $permission->id,
                'action_user_id' => Auth::id()
            ]);

            // Redirecionar o usuario e enviar a mensagem de SUCESSO
            return redirect()->route('role-permissions.index', ['menu' => 'roles', 'role' => $role->id])->with('success', 'Permissão ' . ($action === 'bloquear' ? 'BLOQUEADA' : 'LIBERADA') . ' !');
        } catch (Exception $e) {
            //Salvar LOG
            Log::notice('Permissao para o papel nao editada.', ['error' => $e->getMessage(), 'action_user_id' => Auth::id()]);

            // Redirecionar o usuario e enviar a mensagem de ERRO
            return back()->withInput()->with('error', 'Permissão NÃO alterada!');
        }
    }
}
