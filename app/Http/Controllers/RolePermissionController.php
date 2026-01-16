<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    /**
     * Carrega a view de gerenciamento de permissões
     */
    public function index(Role $role)
    {

        // $this->authorize('viewPermissions', $role);

        $user = Auth::user();
        $isSuperAdmin = $user->hasRole('superadmin');

        // Recuperar as permissões do papel
        $rolePermissions = $role->permissions()->pluck('id')->toArray();

        // Recuperar TODAS as permissões existentes
        $permissions = Permission::orderBy('group')
            ->orderBy('order')
            ->get()
            ->groupBy('group');

        Log::info('Visualizando permissões do papel', [
            'role_id' => $role->id,
            'role_name' => $role->name,
            'user_id' => $user->id,
            'is_superadmin' => $isSuperAdmin
        ]);

        return view('role-permissions.index', [
            'menu' => 'roles',
            'rolePermissions' => $rolePermissions,
            'permissions' => $permissions,
            'role' => $role,
            'isSuperAdmin' => $isSuperAdmin,
        ]);
    }

    /**
     * Adiciona/remove permissão do papel (toggle)
     */
    public function toggle(Role $role, Permission $permission)
    {
        // ✅ Usa a POLICY - superadmin passa automaticamente
        // $this->authorize('managePermissions', $role);

        $user = Auth::user();
        $isSuperAdmin = $user->hasRole('superadmin');

        // Toggle da permissão
        if ($role->hasPermissionTo($permission)) {
            $role->revokePermissionTo($permission);
            $action = "removida";
        } else {
            $role->givePermissionTo($permission);
            $action = "adicionada";
        }

        // Limpar cache do Spatie
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Log::info("Permissão {$action}", [
            'role' => $role->name,
            'permission' => $permission->name,
            'user_id' => $user->id,
            'is_superadmin' => $isSuperAdmin
        ]);

        return back()->with('success', 'Permissão atualizada com sucesso.');
    }
}