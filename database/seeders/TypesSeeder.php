<?php

namespace Database\Seeders;

use Database\Seeders\BaseSeeder;
use Illuminate\Support\Facades\DB;

class TypesSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [['id' => '1', 'name' => 'بائع'], ['id' => '2', 'name' => 'مشتري']];
        DB::table('types')->insert($data);
    }
}
