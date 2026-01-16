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
        $superAdmin = Role::firstOrCreate(['name' => 'superadmin']);
        $admin      = Role::firstOrCreate(['name' => 'admin']);
        $tesoureiro = Role::firstOrCreate(['name' => 'tesoureiro']);
        $auxiliar   = Role::firstOrCreate(['name' => 'auxiliar']);
        $member     = Role::firstOrCreate(['name' => 'membro']);

        // ===== SUPER ADMIN =====
        // Poder total
        $superAdmin->syncPermissions(Permission::all());

        // ===== ADMIN =====
        $admin->syncPermissions([
            // Acesso a módulos
            'access-dashboard',
            'access-users',
            'access-members',
            'access-donations',
            'access-expenses',
            'access-reports',

            // Usuários
            'index-user',
            'show-user',

            // Membros
            'index-member',
            'show-member',
            'create-member',
            'edit-member',

            // Doações
            'index-donation',
            'show-donation',
            'create-donation',

            // Despesas
            'index-expense',
            'show-expense',

            // Perfil
            'show-profile',
            'edit-profile',
            'edit-profile-password',
        ]);

        // ===== TESOUR EIRO =====
        $tesoureiro->syncPermissions([
            // Acesso a módulos
            'access-dashboard',
            'access-donations',
            'access-expenses',
            'access-reports',

            // Doações
            'index-donation',
            'show-donation',
            'create-donation',
            'confirm-donation',

            // Despesas
            'index-expense',
            'show-expense',
            'create-expense',
            'edit-expense',

            // Perfil
            'show-profile',
            'edit-profile',
            'edit-profile-password',
        ]);

        // ===== AUXILIAR =====
        $auxiliar->syncPermissions([
            // Acesso a módulos
            'access-dashboard',
            'access-users',
            'access-members',
            'access-donations',
            'access-cms',

            // Usuários
            'index-user',
            'show-user',
            'edit-user',

            // Membros
            'index-member',
            'show-member',
            'create-member',
            'edit-member',

            // Doações
            'index-donation',
            'show-donation',
            'create-donation',
            'edit-donation',

            // CMS
            'view-cms',
            'create-cms',
            'edit-cms',
            'publish-cms',

            // Perfil
            'show-profile',
            'edit-profile',
            'edit-profile-password',
        ]);

        // ===== MEMBRO =====
        $member->syncPermissions([
            // Acesso a módulos
            'access-dashboard',
            'access-donations',
            'access-transparency',

            // Doações (próprias)
            'create-donation',
            'show-donation',
            'update-tithe',

            // Perfil
            'show-profile',
            'edit-profile',
            'edit-profile-password',
        ]);
    }
}
