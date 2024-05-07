<?php

namespace Database\Seeders\Settings;

use Database\Seeders\BaseSeeder;
use App\Models\V2\Settings\Region;

class CreateRegionSeeder extends BaseSeeder
{
    public function __construct()
    {
        parent::__construct(Region::class);
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parentId = Region::factory()->create([
            'name' => 'السعودية',
        ])?->id;

        $regionValues = [
            [
                'name' => 'جدة',
                'parent_id' => $parentId,
            ],
            [
                'name' => 'الرياض',
                'parent_id' => $parentId,
            ],
        ];

        foreach ($regionValues as $value) {
            Region::factory()->create($value);
        }
    }
}
