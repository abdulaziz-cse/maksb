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
        $projectTypeParentId = PredefinedValue::factory()->create([
            'name' => 'project types',
            'slug' => 'projectType',
        ])?->id;

        $buyerTypeParentId = PredefinedValue::factory()->create([
            'name' => 'buyer types',
            'slug' => 'buyerType',
        ])?->id;

        $buyerStatusParentId = PredefinedValue::factory()->create([
            'name' => 'buyer statues',
            'slug' => 'buyerStatus',
        ])?->id;

        $inquiryStatusParentId = PredefinedValue::factory()->create([
            'name' => 'inquiry statues',
            'slug' => 'inquiryStatus',
        ])?->id;

        $predefinedValues = [
            [
                'name' => 'اونلاين',
                'slug' => 'projectType-online',
                'parent_id' => $projectTypeParentId,
            ],
            [
                'name' => 'اوفلاين',
                'slug' => 'projectType-offline',
                'parent_id' => $projectTypeParentId,
            ],
            [
                'name' => 'PlatForm',
                'slug' => 'buyerType-platform',
                'parent_id' => $buyerTypeParentId,
            ],
            [
                'name' => 'Outsourcing',
                'slug' => 'buyerType-outsourcing',
                'parent_id' => $buyerTypeParentId,
            ],
            [
                'name' => 'Acquisition',
                'slug' => 'buyerStatus-acquisition',
                'parent_id' => $buyerStatusParentId,
            ],
            [
                'name' => 'Waiting For Seller',
                'slug' => 'buyerStatus-waiting-for-seller',
                'parent_id' => $buyerStatusParentId,
            ],
            [
                'name' => 'Incomplete',
                'slug' => 'buyerStatus-incomplete',
                'parent_id' => $buyerStatusParentId,
            ],
            [
                'name' => 'New',
                'slug' => 'inquiryStatus-new',
                'parent_id' => $inquiryStatusParentId,
            ],
            [
                'name' => 'Active',
                'slug' => 'inquiryStatus-active',
                'parent_id' => $inquiryStatusParentId,
            ],
            [
                'name' => 'Closed',
                'slug' => 'inquiryStatus-closed',
                'parent_id' => $inquiryStatusParentId,
            ],
        ];

        foreach ($predefinedValues as $value) {
            PredefinedValue::factory()->create($value);
        }
    }
}