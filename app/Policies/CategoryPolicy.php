<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Category;

class CategoryPolicy
{
    /**
     * Superadmin tem acesso total
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('superadmin')) {
            return true;
        }

        return null;
    }

    /**
     * Listar categorias
     */
    public function viewAny(User $user): bool
    {
        return $user->can('categories.view');
    }

    /**
     * Visualizar categoria
     */
    public function view(User $user, Category $category): bool
    {
        return $user->can('categories.view');
    }

    /**
     * Criar categoria
     */
    public function create(User $user): bool
    {
        return $user->can('categories.create');
    }

    /**
     * Atualizar categoria
     */
    public function update(User $user, Category $category): bool
    {
        return $user->can('categories.edit');
    }

    /**
     * Excluir categoria
     */
    public function delete(User $user, Category $category): bool
    {
        if (!$user->can('categories.delete')) {
            return false;
        }

        // impedir excluir categoria em uso
        if ($category->isUsed()) {
            return false;
        }

        // impedir excluir categoria especial (ex: dízimo)
        if ($category->name === 'Dízimo') {
            return false;
        }

        return true;
    }
}
