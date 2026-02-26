<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Church;

class ChurchSeeder extends Seeder
{
    public function run(): void
    {
        Church::firstOrCreate(
            ['cnpj' => '111111111111'], // evita duplicação
            [
                'name' => 'Nossa Senhora das Graças',
                'address' => 'Independencia',
                'logo' => null,
            ]
        );
    }
}