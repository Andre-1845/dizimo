<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class CmsPolicy
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
     * Determina se o usuário pode visualizar qualquer item do CMS
     */
    public function viewAny(User $user): bool
    {
        // ✅ Permissão para acessar o módulo CMS
        return $user->can('cms.access');
    }

    /**
     * Determina se o usuário pode visualizar um item específico do CMS
     */
    public function view(User $user, Model $model): bool
    {
        // ✅ Se pode acessar o CMS, pode ver
        return $user->can('cms.access');
    }

    /**
     * Determina se o usuário pode criar itens no CMS
     */
    public function create(User $user): bool
    {
        // ✅ Permissão específica para criar
        return $user->can('cms.create');
    }

    /**
     * Determina se o usuário pode atualizar um item do CMS
     */
    public function update(User $user, Model $model): bool
    {
        // ✅ Permissão específica para editar
        return $user->can('cms.edit');
    }

    /**
     * Determina se o usuário pode excluir um item do CMS
     */
    public function delete(User $user, Model $model): bool
    {
        // ✅ Permissão específica para excluir
        return $user->can('cms.delete');
    }

    /**
     * Determina se o usuário pode restaurar um item excluído
     */
    public function restore(User $user, Model $model): bool
    {
        return $user->can('cms.delete');
    }

    /**
     * Determina se o usuário pode excluir permanentemente
     */
    public function forceDelete(User $user, Model $model): bool
    {
        // Apenas superadmin para exclusão permanente
        return $user->hasRole('superadmin');
    }

    /**
     * Determina se o usuário pode publicar conteúdo
     */
    public function publish(User $user, Model $model = null): bool
    {
        // ✅ Permissão específica para publicar
        return $user->can('cms.publish');
    }

    /**
     * Determina se o usuário pode gerenciar atividades
     */
    public function manageActivities(User $user): bool
    {
        return $user->can('cms.activities');
    }

    /**
     * Determina se o usuário pode gerenciar eventos
     */
    public function manageEvents(User $user): bool
    {
        return $user->can('cms.events');
    }

    /**
     * Determina se o usuário pode gerenciar avisos
     */
    public function manageNotices(User $user): bool
    {
        return $user->can('cms.notices');
    }

    /**
     * Determina se o usuário pode gerenciar equipe
     */
    public function manageTeam(User $user): bool
    {
        return $user->can('cms.team');
    }
}
