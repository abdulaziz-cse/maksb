<?php

namespace Database\Seeders\Settings;

use Database\Seeders\BaseSeeder;
use App\Models\V2\Settings\PredefinedValue;

class CreatePredefinedValueSeeder extends BaseSeeder
{
    public function __construct()
    {
        parent::__construct(PredefinedValue::class);
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parentId = PredefinedValue::factory()->create([
            'name' => 'project types',
            'slug' => 'projectType',
        ])?->id;

        $predefinedValues = [
            [
                'name' => 'اونلاين',
                'slug' => 'projectType-online',
                'parent_id' => $parentId,
            ],
            [
                'name' => 'اوفلاين',
                'slug' => 'projectType-offline',
                'parent_id' => $parentId,
            ],
        ];

        foreach ($predefinedValues as $value) {
            PredefinedValue::factory()->create($value);
        }
    }
}