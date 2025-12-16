<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $pendente = Status::firstOrCreate(['name' => 'Pendente']);
        $ativo = Status::firstOrCreate(['name' => 'Ativo']);
        $suspenso = Status::firstOrCreate(['name' => 'Suspenso']);
    }
}
