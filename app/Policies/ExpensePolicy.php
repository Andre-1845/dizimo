<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Expense;

class ExpensePolicy
{
    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'tesoureiro']);
    }

    public function view(User $user, Expense $expense)
    {
        return $this->viewAny($user);
    }

    public function create(User $user)
    {
        return $user->hasAnyRole(['superadmin', 'tesoureiro']);
    }

    public function update(User $user, Expense $expense)
    {
        return $user->hasAnyRole(['superadmin', 'tesoureiro']);
    }

    public function delete(User $user, Expense $expense)
    {
        return $user->hasRole('superadmin');
    }
}