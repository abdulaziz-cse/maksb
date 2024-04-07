<?php

namespace Database\Seeders;

use Database\Seeders\BaseSeeder;
use Illuminate\Support\Facades\DB;

class BuyerStatus extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [['id' => '1', 'name' => 'Acquisition'], ['id' => '2', 'name' => 'Waiting For Seller'], ['id' => '3', 'name' => 'incomplete']];
        DB::table('buyers_status')->insert($data);
    }
}