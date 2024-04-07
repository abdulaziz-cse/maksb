<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class BaseSeeder extends Seeder
{
    public function __construct($model)
    {
        Schema::disableForeignKeyConstraints();
        $model::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
