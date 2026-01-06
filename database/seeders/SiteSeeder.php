<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SiteSectionSeeder::class,
            SiteEventSeeder::class,
            SiteSettingSeeder::class,
        ]);
    }
}
