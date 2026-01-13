<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Donation;

class DonationPolicy
{
    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'tesoureiro', 'auxiliar']);
    }

    public function view(User $user, Donation $donation)
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'tesoureiro'])
            || $donation->user_id === $user->id;
    }

    public function create(User $user)
    {
        return $user->hasAnyRole(['superadmin', 'auxiliar', 'membro']);
    }

    public function update(User $user, Donation $donation)
    {
        // Após confirmação, só SuperAdmin pode alterar
        if ($donation->status === 'confirmada') {
            return $user->hasRole('superadmin');
        }

        // Antes da confirmação
        return $user->hasAnyRole(['superadmin', 'auxiliar']);
    }

    public function confirm(User $user, Donation $donation)
    {
        return $user->hasRole('tesoureiro');
    }

    public function delete(User $user, Donation $donation)
    {
        return $user->hasRole('superadmin');
    }
}