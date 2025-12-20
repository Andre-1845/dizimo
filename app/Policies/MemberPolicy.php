<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Member;

class MemberPolicy
{
    /**
     * Listar membros
     */
    public function viewAny(User $user): bool
    {
        return $user->can('index-member');
    }

    /**
     * Ver um membro específico
     */
    public function view(User $user, Member $member): bool
    {
        return $user->can('show-member')
            || $this->update($user, $member);
    }

    /**
     * Criar membro
     */
    public function create(User $user): bool
    {
        return $user->can('create-member');
    }

    /**
     * Atualizar membro (inclui dízimo)
     */
    public function update(User $user, Member $member): bool
    {
        // Admin, Secretário, Auxiliar
        if ($user->can('edit-member')) {
            return true;
        }

        // O próprio membro pode editar seus dados
        return $member->user_id !== null
            && $member->user_id === $user->id;
    }

    /**
     * Excluir membro
     */
    public function delete(User $user, Member $member): bool
    {
        return $user->can('destroy-member');
    }
}
