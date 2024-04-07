<?php

namespace Database\Seeders;

use Database\Seeders\BaseSeeder;
use Illuminate\Support\Facades\DB;

class BuyerTypes extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [['id' => '1', 'name' => 'Platform'], ['id' => '2', 'name' => 'Outsourcing']];
        DB::table('buyers_types')->insert($data);
    }
}
