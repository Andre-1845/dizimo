<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    /**
     * Apenas Super Admin pode gerenciar permissões
     */
    public function managePermissions(User $user, Role $role): bool
    {
        return $user->hasRole('Super Admin');
    }
}
