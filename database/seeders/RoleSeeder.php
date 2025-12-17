<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $tesoureiro = Role::firstOrCreate(['name' => 'Tesoureiro']);
        $secretario = Role::firstOrCreate(['name' => 'Secretario']);
        $auxiliar = Role::firstOrCreate(['name' => 'Auxiliar']);
        $member = Role::firstOrCreate(['name' => 'Membro']);

        // Permissões do Admin
        $admin->givePermissionTo([

            'index-user',
            'show-user',
            'create-user',
            'destroy-user',
            'edit-roles-user',
            'index-user-status',
            'show-user-status',
            'create-user-status',
            'edit-user-status',
            'destroy-user-status',
            'index-role-permission',
            'show-profile',
            'edit-profile',
            'edit-profile-password',
            'dashboard',
            'view-dashboard-admin',
            'view-dashboard-member',
        ]);

        // Permissões do Professor
        $tesoureiro->givePermissionTo([

            'index-user',
            'show-user',
            'show-profile',
            'edit-profile',
            'edit-profile-password',
            'dashboard',
            'view-dashboard-admin',
            'view-dashboard-member',
        ]);

        // Permissões do Tutor
        $secretario->givePermissionTo([

            'index-user',
            'show-user',
            'create-user',
            'show-profile',
            'edit-profile',
            'edit-profile-password',
            'dashboard',
            'view-dashboard-admin',
            'view-dashboard-member',

        ]);

        // Permissoes do Aluno
        $auxiliar->syncPermissions([

            'index-user',
            'show-user',
            'show-profile',
            'edit-profile',
            'edit-profile-password',
            'dashboard',
            'view-dashboard-member',


        ]);
        // Permissoes do Membro
        $member->syncPermissions([

            'show-profile',
            'edit-profile',
            'edit-profile-password',
            'index-user',
            'show-user',
            'view-dashboard-member',


        ]);
    }
}