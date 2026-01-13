<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'auxiliar']);
    }

    public function view(User $user, User $model)
    {
        return $user->id === $model->id
            || $user->hasAnyRole(['superadmin', 'admin', 'auxiliar']);
    }

    public function update(User $user, User $model)
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'auxiliar']);
    }

    public function delete(User $user, User $model)
    {
        return $user->hasRole('superadmin');
    }
}