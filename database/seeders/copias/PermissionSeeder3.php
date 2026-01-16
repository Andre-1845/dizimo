<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            /*
            |------------------------------------------------------------------
            | ACESSO A MÓDULOS (USAR EM ROTAS E SIDEBAR)
            |------------------------------------------------------------------
            */
            [
                'group' => 'Acesso aos Módulos',
                'items' => [
                    ['name' => 'access-dashboard',   'display' => 'Acessar dashboards'],
                    ['name' => 'access-users',       'display' => 'Acessar usuários'],
                    ['name' => 'access-members',     'display' => 'Acessar membros'],
                    ['name' => 'access-donations',   'display' => 'Acessar doações'],
                    ['name' => 'access-expenses',    'display' => 'Acessar despesas'],
                    ['name' => 'access-cms',         'display' => 'Acessar CMS do site'],
                    ['name' => 'access-reports',     'display' => 'Acessar relatórios'],
                    ['name' => 'access-transparency', 'display' => 'Acessar transparência'],
                    ['name' => 'access-categories', 'display' => 'Acessar categorias'],
                ],
            ],

            /*
            |------------------------------------------------------------------
            | USUÁRIOS
            |------------------------------------------------------------------
            */
            [
                'group' => 'Usuários',
                'items' => [
                    ['name' => 'index-user',        'display' => 'Listar usuários'],
                    ['name' => 'show-user',         'display' => 'Visualizar usuário'],
                    ['name' => 'create-user',       'display' => 'Criar usuário'],
                    ['name' => 'edit-user',         'display' => 'Editar usuário'],
                    ['name' => 'edit-user-password', 'display' => 'Alterar senha de usuário'],
                    ['name' => 'destroy-user',      'display' => 'Excluir usuário'],
                ],
            ],

            /*
            |-------------------------------------------------------------------
            | MEMBROS
            |--------------------------------------------------------------------
            */
            [
                'group' => 'Membros',
                'items' => [
                    ['name' => 'index-member',   'display' => 'Listar membros'],
                    ['name' => 'show-member',    'display' => 'Visualizar membro'],
                    ['name' => 'create-member',  'display' => 'Criar membro'],
                    ['name' => 'edit-member',    'display' => 'Editar membro'],
                    ['name' => 'destroy-member', 'display' => 'Excluir membro'],
                    ['name' => 'update-tithe', 'display' => 'Editar Dízimo'],
                ],
            ],

            /*
            |--------------------------------------------------------------------
            | DOAÇÕES / RECEITAS
            |--------------------------------------------------------------------
            */
            [
                'group' => 'Doações',
                'items' => [
                    ['name' => 'index-donation',   'display' => 'Listar doações'],
                    ['name' => 'show-donation',    'display' => 'Visualizar doação'],
                    ['name' => 'create-donation',  'display' => 'Registrar doação'],
                    ['name' => 'edit-donation',    'display' => 'Editar doação'],
                    ['name' => 'confirm-donation', 'display' => 'Confirmar doação'],
                    ['name' => 'destroy-donation', 'display' => 'Excluir doação'],
                ],
            ],

            /*
            |-------------------------------------------------------------------
            | DESPESAS
            |-------------------------------------------------------------------
            */
            [
                'group' => 'Despesas',
                'items' => [
                    ['name' => 'index-expense',   'display' => 'Listar despesas'],
                    ['name' => 'show-expense',    'display' => 'Visualizar despesa'],
                    ['name' => 'create-expense',  'display' => 'Registrar despesa'],
                    ['name' => 'edit-expense',    'display' => 'Editar despesa'],
                    ['name' => 'destroy-expense', 'display' => 'Excluir despesa'],
                ],
            ],
            /*
            |-------------------------------------------------------------------
            | CATEGORIAS
            |-------------------------------------------------------------------
            */
            [
                'group' => 'Categorias',
                'items' => [
                    ['name' => 'index-category',   'display' => 'Listar categorias'],

                ],
            ],

            /*
            |------------------------------------------------------------------
            | CMS DO SITE
            |------------------------------------------------------------------
            */
            [
                'group' => 'CMS',
                'items' => [
                    ['name' => 'view-cms',    'display' => 'Visualizar CMS'],
                    ['name' => 'create-cms',  'display' => 'Criar conteúdo do site'],
                    ['name' => 'edit-cms',    'display' => 'Editar conteúdo do site'],
                    ['name' => 'delete-cms',  'display' => 'Excluir conteúdo do site'],
                    ['name' => 'publish-cms', 'display' => 'Publicar conteúdo do site'],
                ],
            ],

            /*
            |--------------------------------------------------------------------
            | PAPÉIS E PERMISSÕES (HARD RULE)
            |--------------------------------------------------------------------
            */
            [
                'group' => 'Segurança',
                'items' => [
                    ['name' => 'manage-roles',        'display' => 'Gerenciar papéis'],
                    ['name' => 'manage-permissions',  'display' => 'Gerenciar permissões'],
                ],
            ],
        ];

        foreach ($permissions as $groupData) {
            $order = 1;

            foreach ($groupData['items'] as $item) {
                Permission::updateOrCreate(
                    ['name' => $item['name'], 'guard_name' => 'web'],
                    [
                        'display_name' => $item['display'],
                        'description'  => $item['desc'] ?? null,
                        'group'        => $groupData['group'],
                        'order'        => $order++,
                    ]
                );
            }
        }
    }
}
