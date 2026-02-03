<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\FinancialReport;
use App\Models\User;

class FinancialReportPolicy
{
    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FinancialReport $financialReport): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FinancialReport $financialReport): bool
    {
        return false;
    }


    public function viewAny(User $user): bool
    {
        return $user->can('reports.financial');
    }

    public function view(User $user, FinancialReport $report): bool
    {
        return $user->can('reports.financial');
    }

    public function create(User $user): bool
    {
        return $user->can('reports.create');
    }

    public function update(User $user, FinancialReport $report): bool
    {
        return $user->can('reports.edit');
    }

    public function delete(User $user, FinancialReport $report): bool
    {
        return $user->can('reports.delete');
    }
}