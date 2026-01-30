<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Expense;

class ExpensePolicy
{
    /**
     * Superadmin tem acesso a tudo
     */
    public function before(User $user, string $ability): ?bool
    {
        // ✅ Superadmin pode tudo
        if ($user->hasRole('superadmin')) {
            return true;
        }

        return null; // Continua para outras verificações
    }

    /**
     * Determina se o usuário pode visualizar qualquer despesa
     */
    public function viewAny(User $user): bool
    {
        // ✅ Usa permissão Spatie
        return $user->can('expenses.view');
    }

    /**
     * Determina se o usuário pode visualizar uma despesa específica
     */
    public function view(User $user, Expense $expense): bool
    {
        // ✅ Permissão para ver todas OU se criou a despesa
        return $user->can('expenses.view')
            || $expense->user_id === $user->id;
    }

    /**
     * Determina se o usuário pode criar despesas
     */
    public function create(User $user): bool
    {
        // ✅ Permissão específica
        return $user->can('expenses.create');
    }

    /**
     * Determina se o usuário pode atualizar uma despesa
     */
    public function update(User $user, Expense $expense): bool
    {
        // ✅ Permissão para editar todas
        if ($user->can('expenses.edit')) {
            return true;
        }

        // ✅ Usuário que criou pode editar (se não estiver aprovada)
        if ($expense->user_id === $user->id) {
            // Só pode editar se não estiver aprovada
            return !$expense->is_approved;
        }

        return false;
    }

    /**
     * Determina se o usuário pode excluir uma despesa
     */
    public function delete(User $user, Expense $expense): bool
    {
        // ✅ Permissão específica
        if (!$user->can('expenses.delete')) {
            return false;
        }

        // Não pode excluir despesas aprovadas (a menos que seja superadmin)
        if ($expense->is_approved && !$user->hasRole('superadmin')) {
            return false;
        }

        return true;
    }

    /**
     * Determina se o usuário pode restaurar uma despesa excluída
     */
    public function restore(User $user, Expense $expense): bool
    {
        return $user->can('expenses.delete');
    }

    /**
     * Determina se o usuário pode excluir permanentemente
     */
    public function forceDelete(User $user, Expense $expense): bool
    {
        // Apenas superadmin para exclusão permanente
        return $user->hasRole('superadmin');
    }

    /**
     * Determina se o usuário pode aprovar uma despesa
     */
    public function approve(User $user, Expense $expense): bool
    {
        // ✅ Permissão específica
        return $user->can('expenses.approve');
    }

    /**
     * Determina se o usuário pode importar despesas
     */
    public function import(User $user): bool
    {
        return $user->can('expenses.import');
    }

    /**
     * Determina se o usuário pode exportar despesas
     */
    public function export(User $user): bool
    {
        return $user->can('expenses.export');
    }
}
