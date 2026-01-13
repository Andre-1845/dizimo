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
            | DASHBOARDS
            |------------------------------------------------------------------
            */
            [
                'group' => 'Dashboard',
                'items' => [
                    ['name' => 'view-dashboard-admin',   'display' => 'Dashboard Administrativo', 'desc' => 'Visualizar dashboard administrativo'],
                    ['name' => 'view-dashboard-member',  'display' => 'Dashboard do Membro',        'desc' => 'Visualizar painel do membro'],
                    ['name' => 'view-dashboard-dizimo',  'display' => 'Dashboard de Dízimos',       'desc' => 'Visualizar painel financeiro de dízimos'],
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
                    ['name' => 'index-user',          'display' => 'Listar usuários'],
                    ['name' => 'show-user',           'display' => 'Visualizar usuário'],
                    ['name' => 'create-user',         'display' => 'Criar usuário'],
                    ['name' => 'edit-user',           'display' => 'Editar usuário'],
                    ['name' => 'edit-password-user',  'display' => 'Alterar senha de usuário'],
                    ['name' => 'destroy-user',        'display' => 'Excluir usuário'],
                    ['name' => 'edit-roles-user',     'display' => 'Gerenciar papéis do usuário'],
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
                    ['name' => 'index-member',    'display' => 'Listar membros'],
                    ['name' => 'show-member',     'display' => 'Visualizar membro'],
                    ['name' => 'create-member',   'display' => 'Criar membro'],
                    ['name' => 'edit-member',     'display' => 'Editar membro'],
                    ['name' => 'destroy-member',  'display' => 'Excluir membro'],
                ],
            ],

            /*
            |--------------------------------------------------------------------
            | DOAÇÕES
            |-------------------------------------------------------------------
            */
            [
                'group' => 'Doações',
                'items' => [
                    ['name' => 'index-donation',   'display' => 'Listar doações'],
                    ['name' => 'show-donation',    'display' => 'Visualizar doação'],
                    ['name' => 'create-donation',  'display' => 'Registrar doação'],
                    ['name' => 'edit-donation',    'display' => 'Editar doação'],
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
            |------------------------------------------------------------------
            | CATEGORIAS
            |--------------------------------------------------------------------
            */
            [
                'group' => 'Categorias',
                'items' => [
                    ['name' => 'index-category',   'display' => 'Listar categorias'],
                    ['name' => 'show-category',    'display' => 'Visualizar categoria'],
                    ['name' => 'create-category',  'display' => 'Registrar categoria'],
                    ['name' => 'edit-category',    'display' => 'Editar categoria'],
                    ['name' => 'destroy-category', 'display' => 'Excluir categoria'],
                ],
            ],
            /*
            |------------------------------------------------------------------
            | PERFIL
            |--------------------------------------------------------------------
            */
            [
                'group' => 'Perfil',
                'items' => [
                    ['name' => 'show-profile',           'display' => 'Visualizar perfil'],
                    ['name' => 'edit-profile',           'display' => 'Editar perfil'],
                    ['name' => 'edit-profile-password',  'display' => 'Alterar senha do perfil'],
                ],
            ],

            /*
            |--------------------------------------------------------------------
            | PAPÉIS E PERMISSÕES
            |--------------------------------------------------------------------
            */
            [
                'group' => 'Papéis e Permissões',
                'items' => [
                    ['name' => 'index-role',               'display' => 'Listar papéis'],
                    ['name' => 'show-role',               'display' => 'Mostrar detalhes do papel'],
                    ['name' => 'create-role',              'display' => 'Criar papel'],
                    ['name' => 'edit-role',                'display' => 'Editar papel'],
                    ['name' => 'destroy-role',             'display' => 'Excluir papel'],
                    ['name' => 'index-role-permission',    'display' => 'Gerenciar permissões'],
                    ['name' => 'update-role-permission',   'display' => 'Atualizar permissões'],
                ],
            ],
            /*-------------------------------------------------------------------
            | SITE
            |-------------------------------------------------------------------
            */
            [
                'group' => 'Site',
                'items' => [
                    [
                        ['name' => 'view-site-admin',      'display' => 'Acessar CMS do site'],
                        ['name' => 'edit-site-sections',   'display' => 'Editar seções do site'],
                        ['name' => 'manage-site-gallery',  'display' => 'Gerenciar galeria'],
                        ['name' => 'manage-site-notices',  'display' => 'Gerenciar avisos'],
                        ['name' => 'manage-site-activities', 'display' => 'Gerenciar horários'],
                        ['name' => 'manage-site-events', 'display' => 'Gerenciar eventos(agenda)'],
                    ],
                ],
            ],


            /*
            |---------------------------------------------------------------------
            | STATUS DOS USUÁRIOS
            |--------------------------------------------------------------------
            */
            [
                'group' => 'Status do usuário',
                'items' => [
                    ['name' => 'index-user-status',          'display' => 'Listar status de usuários'],
                    ['name' => 'show-user-status',           'display' => 'Visualizar status de usuário'],
                    ['name' => 'create-user-status',         'display' => 'Criar status de usuário'],
                    ['name' => 'edit-user-status',           'display' => 'Editar status de usuário'],
                    ['name' => 'destroy-user-status',        'display' => 'Excluir status de usuário'],

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