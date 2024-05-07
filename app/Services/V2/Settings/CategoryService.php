<?php

namespace App\Services\V2\Settings;

use App\Models\V2\Settings\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\SettingRepositoryInterface;

class CategoryService
{
    public function __construct(private SettingRepositoryInterface $settingRepositoryInterface)
    {
    }

    public function getMany($categoryFilters): LengthAwarePaginator
    {
        return $this->settingRepositoryInterface->getMany(
            $categoryFilters,
            Category::class
        );
    }
}