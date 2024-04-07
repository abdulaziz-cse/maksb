<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TypesSeeder::class,
            RolesAndPermissionsSeeder::class,
            ProjectTypeSeeder::class,
            CountriesSeeder::class,
            PlatformsSeeder::class,
            CurrenciesSeeder::class,
            AssetsSeeder::class,
            PackagesSeeder::class,
            RevenueSourcesSeeder::class,
            BuyerStatus::class,
            BuyerTypes::class
        ]);
    }
}
