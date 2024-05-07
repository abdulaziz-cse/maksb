<?php

namespace App\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface SettingRepositoryInterface
{
    public function getMany($filters, $model): LengthAwarePaginator;
}