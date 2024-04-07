<?php

namespace Database\Seeders;

use Database\Seeders\BaseSeeder;
use Illuminate\Support\Facades\DB;

class PlatformsSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => '1', 'name' => 'شوبيفاي'], ['id' => '2', 'name' => 'أمازون'], ['id' => '3', 'name' => 'علي بابا'],
            ['id' => '4', 'name' => 'سلة'], ['id' => '5', 'name' => 'زد'], ['id' => '6', 'name' => 'نون']
        ];
        DB::table('platforms')->insert($data);
    }
}