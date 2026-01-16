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
            |--------------------------------------------------------------------------
            | PERMISSÕES DE MÓDULO (Sidebar)
            |--------------------------------------------------------------------------
            */
            [
                'group' => 'Módulos',
                'description' => 'Acesso aos módulos principais do sistema',
                'items' => [
                    ['name' => 'dashboard.access', 'display' => 'Acessar Dashboard'],
                    ['name' => 'users.access', 'display' => 'Acessar Usuários'],
                    ['name' => 'members.access', 'display' => 'Acessar Membros'],
                    ['name' => 'donations.access', 'display' => 'Acessar Doações'],
                    ['name' => 'expenses.access', 'display' => 'Acessar Despesas'],
                    ['name' => 'reports.access', 'display' => 'Acessar Relatórios'],
                    ['name' => 'cms.access', 'display' => 'Acessar CMS'],
                    ['name' => 'transparency.access', 'display' => 'Acessar Transparência'],
                    ['name' => 'categories.access', 'display' => 'Acessar Categorias'],
                    ['name' => 'settings.access', 'display' => 'Acessar Configurações'],
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | USUÁRIOS
            |--------------------------------------------------------------------------
            */
            [
                'group' => 'Usuários',
                'description' => 'Permissões para gerenciamento de usuários',
                'items' => [
                    ['name' => 'users.view', 'display' => 'Ver usuários'],
                    ['name' => 'users.create', 'display' => 'Criar usuários'],
                    ['name' => 'users.edit', 'display' => 'Editar usuários'],
                    ['name' => 'users.delete', 'display' => 'Excluir usuários'],
                    ['name' => 'users.import', 'display' => 'Importar usuários'],
                    ['name' => 'users.export', 'display' => 'Exportar usuários'],
                    ['name' => 'users.change-status', 'display' => 'Alterar status de usuários'],
                    ['name' => 'users.reset-password', 'display' => 'Redefinir senha de usuários'],
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | MEMBROS
            |--------------------------------------------------------------------------
            */
            [
                'group' => 'Membros',
                'description' => 'Permissões para gerenciamento de membros da igreja',
                'items' => [
                    ['name' => 'members.view', 'display' => 'Ver membros'],
                    ['name' => 'members.create', 'display' => 'Cadastrar membros'],
                    ['name' => 'members.edit', 'display' => 'Editar membros'],
                    ['name' => 'members.delete', 'display' => 'Excluir membros'],
                    ['name' => 'members.import', 'display' => 'Importar membros'],
                    ['name' => 'members.export', 'display' => 'Exportar membros'],
                    ['name' => 'members.history', 'display' => 'Ver histórico de membros'],
                    ['name' => 'members.tithe-manage', 'display' => 'Gerenciar dízimo de membros'],
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | RECEITAS , DÍZIMOS E DOAÇÕES
            |--------------------------------------------------------------------------
            */
            [
                'group' => 'Receitas',
                'description' => 'Permissões para registro e gestão de dízimos',
                'items' => [
                    ['name' => 'donations.view', 'display' => 'Ver doações'],
                    ['name' => 'donations.create', 'display' => 'Registrar doação'],
                    ['name' => 'donations.edit', 'display' => 'Editar doação'],
                    ['name' => 'donations.delete', 'display' => 'Excluir doação'],
                    ['name' => 'donations.confirm', 'display' => 'Confirmar doação'],
                    ['name' => 'donations.cancel', 'display' => 'Cancelar doação'],
                    ['name' => 'donations.import', 'display' => 'Importar doações'],
                    ['name' => 'donations.export', 'display' => 'Exportar doações'],
                    ['name' => 'donations.bulk', 'display' => 'Lançamentos em lote'],
                    ['name' => 'donations.reconcile', 'display' => 'Reconciliar lançamentos'],
                    ['name' => 'donations.anonymize', 'display' => 'Anonimizar doações'],
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | DESPESAS
            |--------------------------------------------------------------------------
            */
            [
                'group' => 'Despesas',
                'description' => 'Permissões para gestão de despesas',
                'items' => [
                    ['name' => 'expenses.view', 'display' => 'Ver despesas'],
                    ['name' => 'expenses.create', 'display' => 'Registrar despesa'],
                    ['name' => 'expenses.edit', 'display' => 'Editar despesa'],
                    ['name' => 'expenses.delete', 'display' => 'Excluir despesa'],
                    ['name' => 'expenses.approve', 'display' => 'Aprovar despesas'],
                    ['name' => 'expenses.import', 'display' => 'Importar despesas'],
                    ['name' => 'expenses.export', 'display' => 'Exportar despesas'],
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | RELATÓRIOS
            |--------------------------------------------------------------------------
            */
            [
                'group' => 'Relatórios',
                'description' => 'Permissões para acesso a relatórios',
                'items' => [
                    ['name' => 'reports.financial', 'display' => 'Relatórios financeiros'],
                    ['name' => 'reports.tithes', 'display' => 'Relatórios de dízimos'],
                    ['name' => 'reports.donations', 'display' => 'Relatórios de doações'],
                    ['name' => 'reports.expenses', 'display' => 'Relatórios de despesas'],
                    ['name' => 'reports.members', 'display' => 'Relatórios de membros'],
                    ['name' => 'reports.annual', 'display' => 'Relatório anual'],
                    ['name' => 'reports.comparative', 'display' => 'Relatório comparativo'],
                    ['name' => 'reports.export', 'display' => 'Exportar relatórios'],
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | CATEGORIAS
            |--------------------------------------------------------------------------
            */
            [
                'group' => 'Categorias',
                'description' => 'Permissões para gerenciamento de categorias',
                'items' => [
                    ['name' => 'categories.view', 'display' => 'Ver categorias'],
                    ['name' => 'categories.create', 'display' => 'Criar categorias'],
                    ['name' => 'categories.edit', 'display' => 'Editar categorias'],
                    ['name' => 'categories.delete', 'display' => 'Excluir categorias'],
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | CMS (CONTEÚDO DO SITE)
            |--------------------------------------------------------------------------
            */
            [
                'group' => 'CMS - Site',
                'description' => 'Permissões para gerenciamento do conteúdo do site',
                'items' => [
                    ['name' => 'cms.view', 'display' => 'Ver conteúdo do site'],
                    ['name' => 'cms.create', 'display' => 'Criar conteúdo'],
                    ['name' => 'cms.edit', 'display' => 'Editar conteúdo'],
                    ['name' => 'cms.delete', 'display' => 'Excluir conteúdo'],
                    ['name' => 'cms.publish', 'display' => 'Publicar conteúdo'],
                    ['name' => 'cms.activities', 'display' => 'Gerenciar atividades'],
                    ['name' => 'cms.events', 'display' => 'Gerenciar eventos'],
                    ['name' => 'cms.notices', 'display' => 'Gerenciar avisos'],
                    ['name' => 'cms.team', 'display' => 'Gerenciar equipe'],
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | TRANSPARÊNCIA
            |--------------------------------------------------------------------------
            */
            [
                'group' => 'Transparência',
                'description' => 'Permissões para módulo de transparência financeira',
                'items' => [
                    ['name' => 'transparency.view', 'display' => 'Ver transparência'],
                    ['name' => 'transparency.publish', 'display' => 'Publicar dados'],
                    ['name' => 'transparency.manage', 'display' => 'Gerenciar transparência'],
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | CONFIGURAÇÕES E SEGURANÇA
            |--------------------------------------------------------------------------
            */
            [
                'group' => 'Configurações',
                'description' => 'Permissões para configurações do sistema',
                'items' => [
                    ['name' => 'settings.view', 'display' => 'Ver configurações'],
                    ['name' => 'settings.edit', 'display' => 'Editar configurações'],

                    // Segurança
                    ['name' => 'roles.view', 'display' => 'Ver papéis'],
                    ['name' => 'roles.create', 'display' => 'Criar papéis'],
                    ['name' => 'roles.edit', 'display' => 'Editar papéis'],
                    ['name' => 'roles.delete', 'display' => 'Excluir papéis'],
                    ['name' => 'roles.assign', 'display' => 'Atribuir papéis'],

                    ['name' => 'permissions.view', 'display' => 'Ver permissões'],
                    ['name' => 'permissions.manage', 'display' => 'Gerenciar permissões'],

                    // Sistema
                    ['name' => 'system.logs', 'display' => 'Ver logs do sistema'],
                    ['name' => 'system.backup', 'display' => 'Backup do sistema'],
                    ['name' => 'system.maintenance', 'display' => 'Modo manutenção'],
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | PERFIL
            |--------------------------------------------------------------------------
            */
            [
                'group' => 'Perfil',
                'description' => 'Permissões para gerenciamento do próprio perfil',
                'items' => [
                    ['name' => 'profile.view', 'display' => 'Ver próprio perfil'],
                    ['name' => 'profile.edit', 'display' => 'Editar próprio perfil'],
                    ['name' => 'profile.password', 'display' => 'Alterar própria senha'],
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | DASHBOARDS ESPECÍFICOS
            |--------------------------------------------------------------------------
            */
            [
                'group' => 'Dashboards',
                'description' => 'Permissões para dashboards específicos',
                'items' => [
                    ['name' => 'dashboard.admin', 'display' => 'Dashboard Administrativo'],
                    ['name' => 'dashboard.treasury', 'display' => 'Dashboard Tesouraria'],
                    ['name' => 'dashboard.member', 'display' => 'Dashboard Membro'],
                    ['name' => 'dashboard.dizimo', 'display' => 'Dashboard Dízimo'],
                ],
            ],
        ];

        foreach ($permissions as $groupData) {
            $order = 1;

            foreach ($groupData['items'] as $item) {
                Permission::updateOrCreate(
                    ['name' => $item['name']],
                    [
                        'display_name' => $item['display'],
                        'group' => $groupData['group'],
                        'description' => $groupData['description'] ?? null,
                        'guard_name' => 'web',
                        'order' => $order++,
                    ]
                );
            }
        }

        $this->command->info('✓ Permissões criadas/atualizadas com sucesso!');
    }
}
