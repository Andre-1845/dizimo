<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // ===== ROLES =====
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $admin      = Role::firstOrCreate(['name' => 'Admin']);
        $tesoureiro = Role::firstOrCreate(['name' => 'Tesoureiro']);
        $secretario = Role::firstOrCreate(['name' => 'Secretario']);
        $auxiliar   = Role::firstOrCreate(['name' => 'Auxiliar']);
        $member     = Role::firstOrCreate(['name' => 'Membro']);

        // ===== SUPER ADMIN =====
        // TODAS as permissões
        $superAdmin->syncPermissions(Permission::all());

        // ===== ADMIN =====
        $admin->syncPermissions([

            // Usuários (admin pode TUDO)
            'index-user',
            'show-user',
            'create-user',
            'edit-user',
            'edit-password-user',
            'destroy-user',
            'edit-roles-user',

            // Status
            'index-user-status',
            'show-user-status',
            'create-user-status',
            'edit-user-status',
            'destroy-user-status',

            // Members
            'index-member',
            'show-member',
            'create-member',
            'edit-member',
            'destroy-member',

            // Financeiro
            'index-donation',
            'show-donation',
            'create-donation',
            'edit-donation',
            'destroy-donation',

            'index-expense',
            'show-expense',
            'create-expense',
            'edit-expense',
            'destroy-expense',

            // Categorias
            'index-category',

            // Dashboards
            'view-dashboard-admin',
            'view-dashboard-member',
            'view-dashboard-dizimo',

            // Perfil
            'show-profile',
            'edit-profile',
            'edit-profile-password',
        ]);

        // ===== TESOURERIO =====
        $tesoureiro->syncPermissions([

            // Financeiro
            'index-donation',
            'show-donation',
            'create-donation',
            'edit-donation',

            'index-expense',
            'show-expense',
            'create-expense',
            'edit-expense',

            // Categorias
            'index-category',

            // Dashboards
            'view-dashboard-admin',
            'view-dashboard-dizimo',

            // Perfil
            'show-profile',
            'edit-profile',
            'edit-profile-password',
        ]);

        // ===== SECRETARIO =====
        $secretario->syncPermissions([

            // Usuários (sem deletar)
            'index-user',
            'show-user',
            'create-user',
            'edit-user',
            'edit-password-user',

            // Members
            'index-member',
            'show-member',
            'create-member',
            'edit-member',

            // Dashboards
            'view-dashboard-admin',
            'view-dashboard-member',
            'view-dashboard-dizimo',

            // Perfil
            'show-profile',
            'edit-profile',
            'edit-profile-password',
        ]);

        // ===== AUXILIAR =====
        $auxiliar->syncPermissions([

            // Visualização
            'index-user',
            'show-user',
            'index-member',
            'show-member',

            // Dashboards
            'view-dashboard-member',
            'view-dashboard-dizimo',

            // Perfil
            'show-profile',
            'edit-profile',
            'edit-profile-password',
        ]);

        // ===== MEMBRO =====
        $member->syncPermissions([

            // Perfil próprio
            'show-profile',
            'edit-profile',
            'edit-profile-password',

            // Membro
            'show-member',
            'edit-member',
            'update-tithe',

            // Dashboard
            'view-dashboard-member',
        ]);
    }
}