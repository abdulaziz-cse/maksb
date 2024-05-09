<?php

namespace App\Services\V2\Settings;

use App\Models\V2\Settings\PredefinedValue;
use App\Interfaces\SettingRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class PredefinedValueService
{
    public function __construct(private SettingRepositoryInterface $settingRepositoryInterface)
    {
    }

    public function getMany($predefinedValueFilters): LengthAwarePaginator
    {
        return $this->settingRepositoryInterface->getMany(
            $predefinedValueFilters,
            PredefinedValue::class
        );
    }
}