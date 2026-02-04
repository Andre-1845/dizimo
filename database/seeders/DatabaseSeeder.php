<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        if (App::environment() !== 'production' || env('ALLOW_PROD_SEED', false)) {

            $this->call([
                PermissionSeeder::class,
                StatusSeeder::class,
                RoleSeeder::class,
                UserSeeder::class,
                CategorySeeder::class,
                PaymentMethodSeeder::class,
                SiteSeeder::class,

            ]);
        }
    }
}