// app/Policies/RolePolicy.php
<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determina se o usuário pode visualizar permissões do papel
     *
     * REGRAS:
     * 1. Superadmin pode ver TUDO (qualquer papel)
     * 2. Ninguém mais pode ver o papel 'superadmin'
     * 3. Outros usuários precisam da permissão 'permissions.view'
     */
    public function viewPermissions(User $user, Role $role): bool
    {
        // ✅ SUPERADMIN tem acesso TOTAL
        if ($user->hasRole('superadmin')) {
            return true;
        }

        // ❌ Ninguém mais pode ver o papel superadmin
        if ($role->name === 'superadmin') {
            return false;
        }

        // ✅ Verifica permissão específica
        return $user->can('permissions.view');
    }

    /**
     * Determina se o usuário pode gerenciar permissões do papel
     *
     * REGRAS:
     * 1. Superadmin pode gerenciar TUDO (qualquer papel)
     * 2. Ninguém mais pode gerenciar o papel 'superadmin'
     * 3. Outros usuários precisam da permissão 'permissions.manage'
     */
    public function managePermissions(User $user, Role $role): bool
    {
        // ✅ SUPERADMIN tem acesso TOTAL
        if ($user->hasRole('superadmin')) {
            return true;
        }

        // ❌ Ninguém mais pode gerenciar o papel superadmin
        if ($role->name === 'superadmin') {
            return false;
        }

        // ✅ Verifica permissão específica
        return $user->can('permissions.manage');
    }
}
