<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

        // $this->authorize('managePermissions', $role);

        $user = Auth::user();
        // ✅ Verificação manual
        if (!$user->hasRole('superadmin') && !$user->can('permissions.view')) {
            abort(403, 'Acesso negado');
        }

        if (!$user->hasRole('superadmin') && $role->name === 'superadmin') {
            abort(403, 'Não pode acessar papel superadmin');
        }


        // ✅ CORREÇÃO 1: Superadmin pode ver tudo
        if ($user->hasRole('superadmin')) {
            $rolePermissions = $role->permissions()->pluck('id')->toArray();
            $permissions = Permission::orderBy('group')
                ->orderBy('order')
                ->get()
                ->groupBy('group');

            Log::info('Superadmin visualizando permissões do papel', [
                'role_id' => $role->id,
                'role_name' => $role->name,
                'user_id' => $user->id
            ]);

            return view('role-permissions.index', [
                'menu' => 'roles',
                'rolePermissions' => $rolePermissions,
                'permissions' => $permissions,
                'role' => $role,
                'isSuperAdmin' => true,
            ]);
        }

        // ✅ CORREÇÃO 2: Não-superadmin não pode ver papel superadmin
        if ($role->name === 'superadmin') {
            Log::warning('Tentativa de acesso a papel superadmin', [
                'role_id' => $role->id,
                'user_id' => $user->id
            ]);

            return redirect()->route('roles.index')
                ->with('error', 'Este papel do sistema não pode ser acessado.');
        }

        // ✅ CORREÇÃO 3: Verificar permissão específica
        if (!$user->can('permissions.view')) {
            abort(403, 'Você não tem permissão para visualizar permissões.');
        }

        // Recuperar as permissões do papel
        $rolePermissions = $role->permissions()->pluck('id')->toArray();

        // Recuperar TODAS as permissões existentes
        $permissions = Permission::orderBy('group')
            ->orderBy('order')
            ->get()
            ->groupBy('group');

        Log::info('Listar permissões do papel', [
            'role_id' => $role->id,
            'user_id' => $user->id
        ]);

        return view('role-permissions.index', [
            'menu' => 'roles',
            'rolePermissions' => $rolePermissions,
            'permissions' => $permissions,
            'role' => $role,
            'isSuperAdmin' => false,
        ]);
    }

    public function toggle(Role $role, Permission $permission)
    {
        $this->authorize('managePermissions', $role);
        $user = Auth::user();

        // ✅ CORREÇÃO 1: Superadmin pode modificar tudo
        if ($user->hasRole('superadmin')) {
            // Superadmin pode modificar qualquer papel, exceto remover suas próprias permissões críticas
            if ($role->hasPermissionTo($permission)) {
                $role->revokePermissionTo($permission);
                $action = "Removida";
            } else {
                $role->givePermissionTo($permission);
                $action = "Adicionada";
            }

            Log::info("Superadmin {$action} permissão", [
                'role' => $role->name,
                'permission' => $permission->name,
                'user_id' => $user->id
            ]);

            return back()->with('success', 'Permissão atualizada com sucesso.');
        }

        // ✅ CORREÇÃO 2: Não-superadmin não pode modificar papel superadmin
        if ($role->name === 'superadmin') {
            Log::alert('Tentativa de modificar papel superadmin', [
                'role' => $role->name,
                'user_id' => $user->id
            ]);

            return back()->with('error', 'Este papel do sistema não pode ser modificado.');
        }

        // ✅ CORREÇÃO 3: Verificar permissão específica
        if (!$user->can('permissions.manage')) {
            abort(403, 'Você não tem permissão para gerenciar permissões.');
        }

        // Toggle da permissão
        if ($role->hasPermissionTo($permission)) {
            $role->revokePermissionTo($permission);
            $action = "Removida";
        } else {
            $role->givePermissionTo($permission);
            $action = "Adicionada";
        }

        // Limpar cache do Spatie
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Log::info("Permissão {$action}", [
            'role' => $role->name,
            'permission' => $permission->name,
            'user_id' => $user->id
        ]);

        return back()->with('success', 'Permissão atualizada com sucesso.');
    }
}