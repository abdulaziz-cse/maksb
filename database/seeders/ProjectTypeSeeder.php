<?php

namespace Database\Seeders;

use Database\Seeders\BaseSeeder;
use Illuminate\Support\Facades\DB;

class ProjectTypeSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [['id' => '1', 'name' => 'اونلاين'], ['id' => '2', 'name' => 'اوفلاين']];
        DB::table('project_type')->insert($data);
    }
}
