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
        Status::updateOrCreate(['id' => 1], ['name' => 'Pendente']);
        Status::updateOrCreate(['id' => 2], ['name' => 'Ativo']);
        Status::updateOrCreate(['id' => 3], ['name' => 'Inativo']);
    }
}