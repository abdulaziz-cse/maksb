<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuyerStatus extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [['id'=>'1','name'=>'Acquisition'],['id'=>'2','name'=>'Waiting For Seller'],['id'=>'3','name'=>'incomplete']];
        DB::table('buyers_status')->insert($data);
    }
}
