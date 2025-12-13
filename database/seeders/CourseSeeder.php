<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Course::firstOrCreate(
            ['name' => 'teste'], // condicao teste
            ['name' => 'Teste'], // dados a serem gravados no BD
        );
    }
}
