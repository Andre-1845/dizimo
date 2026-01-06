<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::updateOrInsert([
            ['key' => 'church_name', 'value' => 'Igreja Exemplo'],
            ['key' => 'address', 'value' => 'Rua Principal, 123 - Centro'],
            ['key' => 'phone', 'value' => '(00) 00000-0000'],
            ['key' => 'email', 'value' => 'contato@igrejaexemplo.com'],
            ['key' => 'instagram', 'value' => 'https://instagram.com/igreja'],
            ['key' => 'facebook', 'value' => 'https://facebook.com/igreja'],
        ]);
    }
}
