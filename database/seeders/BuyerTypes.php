<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuyerTypes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [['id'=>'1','name'=>'Platform'],['id'=>'2','name'=>'Outsourcing']];
        DB::table('buyers_types')->insert($data);
    }
}
