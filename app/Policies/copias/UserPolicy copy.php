<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
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
     * Determina se o usuário pode visualizar qualquer usuário
     */
    public function viewAny(User $user): bool
    {
        // ✅ Usa permissão Spatie em vez de roles diretos
        return $user->can('users.view');
    }

    /**
     * Determina se o usuário pode visualizar um usuário específico
     */
    public function view(User $user, User $model): bool
    {
        // ✅ Pode ver todos OU pode ver apenas o próprio perfil
        return true;
    }

    /**
     * Determina se o usuário pode criar usuários
     */
    public function create(User $user): bool
    {
        // ✅ Usa permissão específica
        return $user->can('users.create');
    }

    /**
     * Determina se o usuário pode atualizar um usuário
     */
    public function update(User $user, User $model): bool
    {
        // ✅ Pode editar todos OU pode editar apenas o próprio perfil
        if ($user->id === $model->id) {
            // Edição do próprio perfil usa permissão de profile
            return $user->can('profile.edit');
        }

        return $user->can('users.edit');
    }

    /**
     * Determina se o usuário pode excluir um usuário
     */
    public function delete(User $user, User $model): bool
    {
        // ✅ Não pode excluir a si mesmo
        if ($user->id === $model->id) {
            return false;
        }

        return $user->can('users.delete');
    }

    /**
     * Determina se o usuário pode restaurar um usuário excluído
     */
    public function restore(User $user, User $model): bool
    {
        return $user->can('users.delete'); // Mesma permissão de excluir
    }

    /**
     * Determina se o usuário pode excluir permanentemente
     */
    public function forceDelete(User $user, User $model): bool
    {
        // Apenas superadmin para exclusão permanente
        return $user->hasRole('superadmin');
    }

    /**
     * Determina se o usuário pode redefinir senha de outro usuário
     */
    public function resetPassword(User $user, User $model): bool
    {
        // ✅ Permissão específica para resetar senha
        return $user->can('users.reset-password');
    }

    /**
     * Determina se o usuário pode alterar status de outro usuário
     */
    public function changeStatus(User $user, User $model): bool
    {
        // ✅ Permissão específica
        return $user->can('users.change-status');
    }

    /**
     * Determina se o usuário pode atribuir roles
     */
    public function assignRoles(User $user, User $model): bool
    {
        // Não pode atribuir roles a si mesmo (evita perder acesso)
        if ($user->id === $model->id) {
            return false;
        }

        return $user->can('roles.assign');
    }
}
