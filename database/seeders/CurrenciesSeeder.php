<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

class CurrenciesSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [['id' => '1', 'name' => 'ريال سعودي']];
        DB::table('currencies')->insert($data);
    }
}
