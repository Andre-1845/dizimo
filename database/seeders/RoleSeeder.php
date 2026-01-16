<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = [
            'superadmin' => [
                'display_name' => 'Super Administrador',
                'description' => 'Acesso total ao sistema. Papel para pastor principal ou administrador geral.',
                'permissions' => '*', // Todos
                'protected' => true,
                'hierarchy' => 100,
            ],
            'admin' => [
                'display_name' => 'Administrador',
                'description' => 'Administrador da igreja com acesso amplo, exceto configurações críticas do sistema.',
                'permissions' => [
                    // Módulos
                    'dashboard.access',
                    'users.access',
                    'members.access',
                    'donations.access',
                    'expenses.access',
                    'reports.access',
                    'categories.access',
                    'settings.access',

                    // Usuários
                    'users.view',
                    'users.create',
                    'users.edit',
                    'users.change-status',
                    'users.reset-password',

                    // Membros
                    'members.view',
                    'members.create',
                    'members.edit',
                    'members.delete',
                    'members.tithe-manage',

                    // Dízimos
                    'donations.view',
                    'donations.create',
                    'donations.edit',
                    'donations.confirm',
                    'donations.export',

                    // Despesas
                    'expenses.view',
                    'expenses.create',
                    'expenses.edit',
                    'expenses.approve',

                    // Relatórios
                    'reports.financial',
                    'reports.tithes',
                    'reports.donations',
                    'reports.members',
                    'reports.export',

                    // Categorias
                    'categories.view',
                    'categories.create',
                    'categories.edit',

                    // Configurações
                    'settings.view',
                    'roles.view',
                    'roles.assign',

                    // Dashboards
                    'dashboard.admin',
                    'dashboard.treasury',

                    // Perfil (CORRIGIDO: sem wildcard)
                    'profile.view',
                    'profile.edit',
                    'profile.password',
                ],
                'protected' => true,
                'hierarchy' => 90,
            ],
            'tesoureiro' => [
                'display_name' => 'Tesoureiro',
                'description' => 'Responsável pelas finanças da igreja. Gerencia dízimos, doações e despesas.',
                'permissions' => [
                    // Módulos
                    'dashboard.access',
                    'donations.access',
                    'expenses.access',
                    'reports.access',
                    'categories.access',

                    // Dízimos
                    'donations.view',
                    'donations.create',
                    'donations.edit',
                    'donations.confirm',
                    'donations.cancel',
                    'donations.export',
                    'donations.bulk',
                    'donations.reconcile',

                    // Despesas
                    'expenses.view',
                    'expenses.create',
                    'expenses.edit',
                    'expenses.approve',
                    'expenses.export',

                    // Relatórios
                    'reports.financial',
                    'reports.tithes',
                    'reports.donations',
                    'reports.expenses',
                    'reports.export',

                    // Categorias
                    'categories.view',

                    // Membros
                    'members.view',
                    'members.tithe-manage',

                    // Dashboards
                    'dashboard.treasury',

                    // Perfil (CORRIGIDO)
                    'profile.view',
                    'profile.edit',
                    'profile.password',
                ],
                'protected' => true,
                'hierarchy' => 80,
            ],
            'secretario' => [
                'display_name' => 'Secretário',
                'description' => 'Responsável pelo cadastro de membros e usuários. Suporte administrativo.',
                'permissions' => [
                    // Módulos
                    'dashboard.access',
                    'users.access',
                    'members.access',
                    'donations.access',

                    // Usuários
                    'users.view',
                    'users.create',
                    'users.edit',

                    // Membros
                    'members.view',
                    'members.create',
                    'members.edit',
                    'members.export',

                    // Dízimos
                    'donations.view',
                    'donations.create',

                    // Relatórios
                    'reports.members',

                    // Dashboard
                    'dashboard.admin',

                    // Perfil (CORRIGIDO)
                    'profile.view',
                    'profile.edit',
                    'profile.password',
                ],
                'protected' => false,
                'hierarchy' => 70,
            ],
            'auxiliar' => [
                'display_name' => 'Auxiliar',
                'description' => 'Auxiliar administrativo com permissões limitadas.',
                'permissions' => [
                    // Módulos
                    'dashboard.access',
                    'members.access',
                    'donations.access',

                    // Membros
                    'members.view',

                    // Dízimos
                    'donations.view',

                    // CMS
                    'cms.access',
                    'cms.view',
                    'cms.events',
                    'cms.notices',

                    // Perfil (CORRIGIDO)
                    'profile.view',
                    'profile.edit',
                    'profile.password',
                ],
                'protected' => false,
                'hierarchy' => 60,
            ],
            'membro' => [
                'display_name' => 'Membro',
                'description' => 'Membro da igreja com acesso ao próprio perfil e registro de dízimos.',
                'permissions' => [
                    // Módulos
                    'dashboard.access',
                    'transparency.access',

                    // Dashboard
                    'dashboard.member',

                    // Dízimos
                    'donations.create',
                    'members.tithe-manage',

                    // Transparência
                    'transparency.view',

                    // Perfil (CORRIGIDO)
                    'profile.view',
                    'profile.edit',
                    'profile.password',
                ],
                'protected' => true,
                'hierarchy' => 50,
            ],
        ];

        foreach ($roles as $name => $data) {
            $role = Role::updateOrCreate(
                ['name' => $name],
                [
                    'display_name' => $data['display_name'],
                    'description' => $data['description'],
                    'guard_name' => 'web',
                    'is_protected' => $data['protected'] ?? false,
                ]
            );

            // Atribuir hierarquia se existir coluna
            if (isset($data['hierarchy'])) {
                $role->update(['hierarchy_level' => $data['hierarchy']]);
            }

            // Atribuir permissões
            if ($data['permissions'] === '*') {
                $role->syncPermissions(Permission::all());
            } else {
                $role->syncPermissions($data['permissions']);
            }

            $this->command->info("✓ Papel '{$data['display_name']}' criado com " .
                count($data['permissions'] === '*' ? Permission::all() : $data['permissions']) . " permissões");
        }

        $this->command->info('✓ Papéis criados com sucesso!');
    }
}