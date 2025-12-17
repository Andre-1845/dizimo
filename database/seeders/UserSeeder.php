<?php

namespace Database\Seeders;

use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        try {
            // SUPER ADMIN
            $superAdmin = User::firstOrCreate(
                ['email' => 'superadmin@celke.com'],
                [
                    'name' => 'SuperAdmin',
                    'password' => bcrypt('123456A#'),
                ]
            );

            $superAdmin->assignRole('Super Admin');


            // ADMIN
            $admin = User::firstOrCreate(
                ['email' => 'admin@celke.com'],
                [
                    'name' => 'Admin',
                    'password' => bcrypt('123456A#'),
                ]
            );

            $admin->assignRole('Admin');


            // TUTOR
            $tesoureiro = User::firstOrCreate(
                ['email' => 'tesoureiro@celke.com'],
                [
                    'name' => 'Tesoureiro',
                    'password' => bcrypt('123456A#'),
                ]
            );

            $tesoureiro->assignRole('Tesoureiro');


            // STUDENT
            $secretario = User::firstOrCreate(
                ['email' => 'secretario@celke.com'],
                [
                    'name' => 'Secretario',
                    'password' => bcrypt('123456A#'),
                ]
            );

            $secretario->assignRole('Secretario');


            // TEACHER
            $auxiliar = User::firstOrCreate(
                ['email' => 'auxiliar@celke.com'],
                [
                    'name' => 'Auxiliar',
                    'password' => bcrypt('123456A#'),
                ]
            );

            $auxiliar->assignRole('Auxiliar');
        } catch (Exception $e) {
            Log::notice('Usuario nao cadastrado na SEED', ['error' => $e->getMessage()]);
        }
    }
}