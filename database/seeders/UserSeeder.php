<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Garantir que existe status 'Ativo'
        $statusAtivo = Status::firstOrCreate(['name' => 'Ativo']);

        // 1. SUPER ADMIN
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@igreja.com'],
            [
                'name' => 'Super Administrador',
                'password' => Hash::make('senha123'),
                'status_id' => $statusAtivo->id,
                'email_verified_at' => now(),
            ]
        );

        $superAdmin->assignRole('superadmin');
        $this->command->info("✓ Super Admin criado: superadmin@igreja.com / senha123");

        // 2. ADMINISTRADOR
        $admin = User::updateOrCreate(
            ['email' => 'admin@igreja.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('senha123'),
                'status_id' => $statusAtivo->id,
                'email_verified_at' => now(),
            ]
        );

        $admin->assignRole('admin');
        $this->command->info("✓ Admin criado: admin@igreja.com / senha123");

        // 3. TESOUREIRO
        $tesoureiro = User::updateOrCreate(
            ['email' => 'tesoureiro@igreja.com'],
            [
                'name' => 'Tesoureiro',
                'password' => Hash::make('senha123'),
                'status_id' => $statusAtivo->id,
                'email_verified_at' => now(),
            ]
        );

        $tesoureiro->assignRole('tesoureiro');
        $this->command->info("✓ Tesoureiro criado: tesoureiro@igreja.com / senha123");

        // 4. SECRETÁRIO
        $secretario = User::updateOrCreate(
            ['email' => 'secretario@igreja.com'],
            [
                'name' => 'Secretário',
                'password' => Hash::make('senha123'),
                'status_id' => $statusAtivo->id,
                'email_verified_at' => now(),
            ]
        );

        $secretario->assignRole('secretario');
        $this->command->info("✓ Secretário criado: secretario@igreja.com / senha123");

        // 5. MEMBRO
        $membro = User::updateOrCreate(
            ['email' => 'membro@igreja.com'],
            [
                'name' => 'Membro Exemplo',
                'password' => Hash::make('senha123'),
                'status_id' => $statusAtivo->id,
                'email_verified_at' => now(),
            ]
        );

        $membro->assignRole('membro');
        $this->command->info("✓ Membro criado: membro@igreja.com / senha123");

        $this->command->warn("ATENÇÃO: Altere as senhas imediatamente!");
        $this->command->info("Todos os usuários têm a senha: senha123");
    }
}