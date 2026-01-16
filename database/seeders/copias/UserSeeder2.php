<?php

namespace Database\Seeders;

use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            // *********    Perfil SUPER ADMIN
            $superAdmin = User::firstOrCreate(
                ['email' => 'superadmin@celke.com'],
                [
                    'name' => 'SuperAdmin',
                    'status_id' => '2',
                    'password' => '123456A#',
                ]
            );

            $superAdmin->assignRole('Super Admin');


            // *********    Perfil ADMIN
            $admin = User::firstOrCreate(
                ['email' => 'admin@celke.com'],
                [
                    'name' => 'Admin',
                    'status_id' => '2',
                    'password' => '123456A#',
                ]
            );

            $admin->assignRole('Admin');


            //   *********    Perfil TESOUREIRO
            $tesoureiro = User::firstOrCreate(
                ['email' => 'tesoureiro@celke'],
                [
                    'name' => 'Tesoureiro',
                    'status_id' => '2',
                    'password' => '123456A#',
                ]
            );

            $tesoureiro->assignRole('Tesoureiro');


            // *********    Perfil SECRETARIO
            $secretario = User::firstOrCreate(
                ['email' => 'secretario@celke.com'],
                [
                    'name' => 'Secretario',
                    'status_id' => '2',
                    'password' => '123456A#',
                ]
            );

            $secretario->assignRole('Secretario');


            //   *********    Perfil AUXILIAR
            $auxiliar = User::firstOrCreate(
                ['email' => 'auxiliar@celke.com'],
                [
                    'name' => 'Auxiliar',
                    'status_id' => '2',
                    'password' => '123456A#',
                ]
            );

            $auxiliar->assignRole('Auxiliar');
        } catch (Exception $e) {
            Log::notice('Usuario nao cadastrado na SEED', ['error' => $e->getMessage()]);
        }
    }
}
