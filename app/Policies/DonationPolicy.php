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
        // ✅ Superadmin pode tudo
        if ($user->hasRole('superadmin')) {
            return true;
        }

        return null; // Continua para outras verificações
    }

    /**
     * Determina se o usuário pode visualizar qualquer doação
     */
    public function viewAny(User $user): bool
    {
        // ✅ Permissão para ver todas as doações
        return $user->can('donations.view');
    }

    /**
     * Determina se o usuário pode visualizar uma doação específica
     */
    public function view(User $user, Donation $donation): bool
    {
        // ✅ Permissão para ver todas
        if ($user->can('donations.view')) {
            return true;
        }

        // ✅ Pode ver apenas as próprias doações
        if ($user->can('donations.view-own')) {
            return $donation->user_id === $user->id;
        }

        return false;
    }

    /**
     * Determina se o usuário pode criar doações
     */
    public function create(User $user): bool
    {
        // ✅ Permissão para criar doações (próprias ou de outros)
        return $user->can('donations.create');
    }

    /**
     * Determina se o usuário pode criar doações em nome próprio
     */
    public function createOwn(User $user): bool
    {
        // ✅ Qualquer usuário autenticado pode criar doação própria
        // (membros comuns)
        return $user->hasRole('membro') || $user->can('donations.create');
    }

    /**
     * Determina se o usuário pode atualizar uma doação
     */
    public function update(User $user, Donation $donation): bool
    {
        // ✅ Permissão para editar qualquer doação
        if ($user->can('donations.edit')) {
            // Não pode editar doações confirmadas (a menos que cancele primeiro)
            return $donation->status !== 'confirmada';
        }

        // ✅ Pode editar apenas própria doação (se não confirmada)
        if ($donation->user_id === $user->id && $user->can('donations.edit-own')) {
            return $donation->status !== 'confirmada';
        }

        return false;
    }

    /**
     * Determina se o usuário pode excluir uma doação
     */
    public function delete(User $user, Donation $donation): bool
    {
        // ✅ Permissão para excluir qualquer doação
        if ($user->can('donations.delete')) {
            // Não pode excluir doações confirmadas
            return $donation->status !== 'confirmada';
        }

        // ✅ Pode excluir apenas própria doação (se não confirmada)
        if ($donation->user_id === $user->id) {
            return $donation->status !== 'confirmada';
        }

        return false;
    }

    /**
     * Determina se o usuário pode restaurar uma doação excluída
     */
    public function restore(User $user, Donation $donation): bool
    {
        return $user->can('donations.delete');
    }

    /**
     * Determina se o usuário pode excluir permanentemente
     */
    public function forceDelete(User $user, Donation $donation): bool
    {
        // Apenas superadmin para exclusão permanente
        return $user->hasRole('superadmin');
    }

    /**
     * Determina se o usuário pode confirmar uma doação
     */
    public function confirm(User $user, Donation $donation): bool
    {
        // ✅ Permissão específica
        return $user->can('donations.confirm');
    }

    /**
     * Determina se o usuário pode cancelar uma doação confirmada
     */
    public function cancel(User $user, Donation $donation): bool
    {
        // ✅ Permissão específica
        return $user->can('donations.cancel');
    }

    /**
     * Determina se o usuário pode anonimizar uma doação
     */
    public function anonymize(User $user, Donation $donation): bool
    {
        return $user->can('donations.anonymize');
    }

    /**
     * Determina se o usuário pode importar doações
     */
    public function import(User $user): bool
    {
        return $user->can('donations.import');
    }

    /**
     * Determina se o usuário pode exportar doações
     */
    public function export(User $user): bool
    {
        return $user->can('donations.export');
    }

    /**
     * Determina se o usuário pode fazer lançamentos em lote
     */
    public function bulk(User $user): bool
    {
        return $user->can('donations.bulk');
    }

    /**
     * Determina se o usuário pode reconciliar doações
     */
    public function reconcile(User $user): bool
    {
        return $user->can('donations.reconcile');
    }
}
