<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permissions = [

            'index-role',
            'show-role',
            'create-role',
            'edit-role',
            'destroy-role',

            'index-user',
            'show-user',
            'create-user',
            'edit-user',
            'edit-password-user',
            'destroy-user',
            'edit-roles-user',

            'index-user-status',
            'show-user-status',
            'create-user-status',
            'edit-user-status',
            'destroy-user-status',

            'show-profile',
            'edit-profile',
            'edit-profile-password',

            'dashboard',
            'view-dashboard-admin',
            'view-dashboard-member',
            'view-dashboard-dizimo',

            'index-member',
            'show-member',
            'create-member',
            'edit-member',
            'destroy-member',
            'update-tithe',

            'index-category',

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

            'index-role-permission',
            'update-role-permission',

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}
