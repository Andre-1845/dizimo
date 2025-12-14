<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Categorias de DOAÇÃO
            ['name' => 'Dízimo', 'type' => 'income'],
            ['name' => 'Oferta', 'type' => 'income'],
            ['name' => 'Oferta Especial', 'type' => 'income'],
            ['name' => 'Campanha', 'type' => 'income'],

            // Categorias de DESPESA
            ['name' => 'Água', 'type' => 'expense'],
            ['name' => 'Energia', 'type' => 'expense'],
            ['name' => 'Manutenção', 'type' => 'expense'],
            ['name' => 'Material', 'type' => 'expense'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                [
                    'name' => $category['name'],
                    'type' => $category['type'],
                ]
            );
        }
    }
}
