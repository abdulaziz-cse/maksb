<?php

namespace Database\Seeders;

use Database\Seeders\BaseSeeder;
use Illuminate\Support\Facades\DB;

class CountriesSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [['id' => '1', 'name' => 'السعودية']];
        DB::table('countries')->insert($data);
    }
}
