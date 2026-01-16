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
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RolePermissionController extends Controller
{
    use AuthorizesRequests;
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
        $permissions = Permission::orderBy('group')
            ->orderBy('order')
            ->get()
            ->groupBy('group');

        // Salvar LOG
        Log::info('Listar permissoes do papel.', ['role_id' => $role->id, 'action_user_id' => Auth::id()]);

        return view('role-permissions.index', [
            'menu' => 'roles',
            'rolePermissions' => $rolePermissions,
            'permissions' => $permissions,
            'role' => $role,
        ]);
    }

    public function toggle(Role $role, Permission $permission)
    {
        $this->authorize('managePermissions', $role);

        if ($role->hasPermissionTo($permission)) {
            $role->revokePermissionTo($permission);
            $action = "Bloqueada";
        } else {
            $role->givePermissionTo($permission);
            $action = "Liberada";
        }
        //Salvar LOG
        Log::info($action . ' permissao para o papel.', [
            'role_id' => $role->id,
            'permission_id' => $permission->id,
            'action_user_id' => Auth::id()
        ]);
        return back()->with('success', 'Permissão atualizada com sucesso.');
    }
}
