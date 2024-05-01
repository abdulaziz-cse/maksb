<?php

namespace App\Services\V2\Settings;

use App\Models\V2\Settings\Region;
use App\Interfaces\SettingRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class RegionService
{
    public function __construct(private SettingRepositoryInterface $settingRepositoryInterface)
    {
    }

    public function getMany($regionFilters): LengthAwarePaginator
    {
        return $this->settingRepositoryInterface->getMany(
            $regionFilters,
            Region::class
        );
    }
}