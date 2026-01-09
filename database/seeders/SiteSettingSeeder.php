<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'church_name' => 'Igreja Exemplo',
            'address'     => 'Rua Principal, 123 - Centro',
            'phone'       => '(00) 00000-0000',
            'email'       => 'contato@igrejaexemplo.com',
            'instagram'   => 'https://instagram.com/igreja',
            'facebook'    => 'https://facebook.com/igreja',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::updateOrInsert(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
