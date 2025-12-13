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
            $tutor = User::firstOrCreate(
                ['email' => 'tutor@celke.com'],
                [
                    'name' => 'Tutor',
                    'password' => bcrypt('123456A#'),
                ]
            );

            $tutor->assignRole('Tutor');


            // STUDENT
            $student = User::firstOrCreate(
                ['email' => 'student@celke.com'],
                [
                    'name' => 'Student',
                    'password' => bcrypt('123456A#'),
                ]
            );

            $student->assignRole('Aluno');


            // TEACHER
            $teacher = User::firstOrCreate(
                ['email' => 'teacher@celke.com'],
                [
                    'name' => 'Professor',
                    'password' => bcrypt('123456A#'),
                ]
            );

            $teacher->assignRole('Professor');
        } catch (Exception $e) {
            Log::notice('Usuario nao cadastrado na SEED', ['error' => $e->getMessage()]);
        }
    }
}