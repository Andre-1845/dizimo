<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSection;

class SiteSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'key'   => 'hero',
                'title' => 'Bem-vindo à nossa Igreja',
                'subtitle' => 'Um lugar de fé, amor e comunhão',
                'order' => 1,
            ],
            [
                'key'   => 'welcome',
                'title' => 'Seja bem-vindo',
                'content' => 'Nossa igreja é um lugar de acolhimento, fé e crescimento espiritual.',
                'order' => 2,
            ],
            [
                'key'   => 'about',
                'title' => 'Quem Somos',
                'content' => 'Somos uma igreja comprometida com o evangelho e com o amor ao próximo.',
                'order' => 3,
            ],
            [
                'key'   => 'gallery',
                'title' => 'Galeria',
                'order' => 4,
            ],
            [
                'key'   => 'contact',
                'title' => 'Contato',
                'order' => 5,
            ],
        ];

        foreach ($sections as $section) {
            SiteSection::updateOrInsert(
                ['key' => $section['key']], // condição
                $section                  // valores
            );
        }
    }
}
