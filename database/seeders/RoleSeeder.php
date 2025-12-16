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
        $teacher = Role::firstOrCreate(['name' => 'Professor']);
        $tutor = Role::firstOrCreate(['name' => 'Tutor']);
        $student = Role::firstOrCreate(['name' => 'Aluno']);
        $member = Role::firstOrCreate(['name' => 'Membro']);

        // Permissões do Admin
        $admin->givePermissionTo([
            'index-course',
            'show-course',
            'create-course',
            'edit-course',
            'destroy-course',
            'index-user',
            'show-user',
            'create-user',
            'dashboard',
            'view-dashboard-admin',
            'show-profile',
            'edit-profile',
            'edit-profile-password',
        ]);

        // Permissões do Professor
        $teacher->givePermissionTo([
            'index-course',
            'show-course',
            'create-course',
            'edit-course',
            'destroy-course',
            'index-user',
            'show-user',
            'dashboard',
            'show-profile',
            'edit-profile',
            'edit-profile-password',
        ]);

        // Permissões do Tutor
        $tutor->givePermissionTo([
            'index-course',
            'show-course',
            'edit-course',
            'dashboard',
            'show-profile',
            'edit-profile',
            'edit-profile-password',

        ]);

        // Permissoes do Aluno
        $student->syncPermissions([
            'index-course',
            'show-course',
            'index-user',
            'show-user',
            'dashboard',
            'show-profile',
            'edit-profile',
            'edit-profile-password',


        ]);
        // Permissoes do Membro
        $member->syncPermissions([

            'view-dashboard-member',
            'show-profile',
            'edit-profile',
            'edit-profile-password',
            // permissoes de Aluno
            'index-course',
            'show-course',
            'index-user',
            'show-user',
            'dashboard',


        ]);
    }
}
