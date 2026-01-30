<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Donation;

class DonationPolicy
{
    /**
     * Superadmin tem acesso a tudo
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('superadmin')) {
            return true;
        }

        return null;
    }

    /**
     * Listar doações
     */
    public function viewAny(User $user): bool
    {
        return $user->can('donations.view');
    }

    /**
     * Visualizar doação específica
     */
    public function view(User $user, Donation $donation): bool
    {
        if ($user->can('donations.view')) {
            return true;
        }

        // Próprias doações
        return $donation->user_id === $user->id
            && $user->can('donations.view-own');
    }

    /**
     * Criar doações (gestão)
     */
    public function create(User $user): bool
    {
        return $user->can('donations.create');
    }

    /**
     * Criar doação própria (membros)
     */
    public function createOwn(User $user): bool
    {
        return $user->can('donations.create-own')
            || $user->can('donations.create');
    }

    /**
     * Atualizar doação
     */
    public function update(User $user, Donation $donation): bool
    {
        // Gestão
        if ($user->can('donations.edit')) {
            return !$donation->is_confirmed;
        }

        // Própria doação
        if (
            $donation->user_id === $user->id
            && $user->can('donations.edit-own')
        ) {
            return !$donation->is_confirmed;
        }

        return false;
    }

    /**
     * Excluir doação
     */
    public function delete(User $user, Donation $donation): bool
    {
        if ($user->can('donations.delete')) {
            return !$donation->is_confirmed;
        }

        if ($donation->user_id === $user->id) {
            return !$donation->is_confirmed;
        }

        return false;
    }

    /**
     * Restaurar doação
     */
    public function restore(User $user, Donation $donation): bool
    {
        return $user->can('donations.delete');
    }

    /**
     * Exclusão permanente
     */
    public function forceDelete(User $user, Donation $donation): bool
    {
        return $user->hasRole('superadmin');
    }

    /**
     * Confirmar doação
     */
    public function confirm(User $user, Donation $donation): bool
    {
        return $user->can('donations.confirm')
            && !$donation->is_confirmed;
    }

    /**
     * Cancelar doação confirmada
     */
    public function cancel(User $user, Donation $donation): bool
    {
        return $user->can('donations.cancel')
            && $donation->is_confirmed;
    }

    /**
     * Anonimizar doação
     */
    public function anonymize(User $user, Donation $donation): bool
    {
        return $user->can('donations.anonymize');
    }

    /**
     * Importar doações
     */
    public function import(User $user): bool
    {
        return $user->can('donations.import');
    }

    /**
     * Exportar doações
     */
    public function export(User $user): bool
    {
        return $user->can('donations.export');
    }

    /**
     * Lançamentos em lote
     */
    public function bulk(User $user): bool
    {
        return $user->can('donations.bulk');
    }

    /**
     * Reconciliar doações
     */
    public function reconcile(User $user): bool
    {
        return $user->can('donations.reconcile');
    }
}
