<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Member;

class MemberPolicy
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
     * Determina se o usuário pode visualizar qualquer membro
     */
    public function viewAny(User $user): bool
    {
        // ✅ Atualizado para nova nomenclatura
        return true;
    }

    /**
     * Determina se o usuário pode visualizar um membro específico
     */
    public function view(User $user, Member $member): bool
    {
        // Pode ver qualquer membro (gestão)
        if ($user->can('members.view')) {
            return true;
        }

        // Pode ver o próprio cadastro de membro
        return $member->user_id === $user->id;
    }

    /**
     * Determina se o usuário pode criar membros
     */
    public function create(User $user): bool
    {
        // ✅ Atualizado
        return $user->can('members.create');
    }

    /**
     * Determina se o usuário pode atualizar um membro
     */
    public function update(User $user, Member $member): bool
    {
        // ✅ Permissão específica
        if ($user->can('members.edit')) {
            return true;
        }

        // ✅ O próprio membro pode editar seus dados
        if ($member->user_id && $member->user_id === $user->id) {
            // Membro pode editar apenas informações básicas, não tudo
            // Você pode adicionar lógica específica aqui
            return true;
        }

        return false;
    }

    /**
     * Determina se o usuário pode excluir um membro
     */
    public function delete(User $user, Member $member): bool
    {
        // ✅ Atualizado
        return $user->can('members.delete');
    }

    /**
     * Determina se o usuário pode restaurar um membro excluído
     */
    public function restore(User $user, Member $member): bool
    {
        return $user->can('members.delete');
    }

    /**
     * Determina se o usuário pode excluir permanentemente
     */
    public function forceDelete(User $user, Member $member): bool
    {
        // Apenas superadmin para exclusão permanente
        return $user->hasRole('superadmin');
    }

    /**
     * Determina se o usuário pode gerenciar dízimo do membro
     */
    public function manageTithe(User $user, Member $member): bool
    {
        // ✅ Permissão específica para gerenciar dízimo
        return $user->can('members.tithe-manage');
    }

    /**
     * Determina se o usuário pode importar membros
     */
    public function import(User $user): bool
    {
        return $user->can('members.import');
    }

    /**
     * Determina se o usuário pode exportar membros
     */
    public function export(User $user): bool
    {
        return $user->can('members.export');
    }
}
