<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteEvent;
use Carbon\Carbon;

class SiteEventSeeder extends Seeder
{
    public function run(): void
    {
        SiteEvent::updateOrInsert(
            [
                'title' => 'Culto de Domingo',
                'event_date' => Carbon::now()->next('Sunday'),
            ],
            [
                'time' => '19:00',
                'description' => 'Culto principal da semana.',
                'is_active' => true,
            ]
        );

        SiteEvent::updateOrInsert(
            [
                'title' => 'Estudo Bíblico',
                'event_date' => Carbon::now()->next('Wednesday'),
            ],
            [
                'time' => '20:00',
                'description' => 'Momento de aprendizado e comunhão.',
                'is_active' => true,
            ]
        );
    }
}
