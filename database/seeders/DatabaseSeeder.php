<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\ProjectTypeSeeder;
use Database\Seeders\Settings\CreateRegionSeeder;
use Database\Seeders\Settings\CreatePredefinedValueSeeder;

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
            CountriesSeeder::class,
            PlatformsSeeder::class,
            CurrenciesSeeder::class,
            AssetsSeeder::class,
            PackagesSeeder::class,
            RevenueSourcesSeeder::class,
            BuyerStatus::class,
            BuyerTypes::class,
            CreatePredefinedValueSeeder::class,
            CreateRegionSeeder::class,
            ProjectTypeSeeder::class,
        ]);
    }
}