<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    /**
     * Determina se o usuário pode visualizar permissões de um papel
     */
    public function viewPermissions(User $user, Role $role): bool
    {
        // Superadmin pode ver tudo
        if ($user->hasRole('superadmin')) {
            return true;
        }

        // Outros usuários precisam da permissão específica
        return $user->can('permissions.view');
    }

    /**
     * Determina se o usuário pode gerenciar permissões de um papel
     */
    public function managePermissions(User $user, Role $role): bool
    {
        // Superadmin pode gerenciar tudo
        if ($user->hasRole('superadmin')) {
            return true;
        }

        // Não permitir modificar papel superadmin
        if ($role->name === 'superadmin') {
            return false;
        }

        // Outros usuários precisam da permissão específica
        return $user->can('permissions.manage');
    }

    /**
     * Determina se o usuário pode excluir um papel
     */
    public function delete(User $user, Role $role): bool
    {
        // Não permitir excluir papéis protegidos do sistema
        $protectedRoles = ['superadmin', 'admin', 'membro'];

        if (in_array($role->name, $protectedRoles)) {
            return false;
        }

        return $user->can('roles.delete');
    }

    /**
     * Método before (executa antes de qualquer outro)
     * Superadmin tem acesso a tudo
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('superadmin')) {
            return true;
        }

        return null; // Continua para outras verificações
    }
}
