<?php

namespace App\Policies;

use App\Models\User;

class CmsPolicy
{
    public function view(User $user)
    {
        return $user->hasAnyRole(['superadmin', 'auxiliar']);
    }

    public function create(User $user)
    {
        return $user->hasAnyRole(['superadmin', 'auxiliar']);
    }

    public function update(User $user)
    {
        return $user->hasAnyRole(['superadmin', 'auxiliar']);
    }

    public function delete(User $user)
    {
        return $user->hasRole('superadmin');
    }

    public function publish(User $user)
    {
        return $user->hasAnyRole(['superadmin', 'auxiliar']);
    }
}