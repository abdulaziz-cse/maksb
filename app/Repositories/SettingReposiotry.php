<?php

namespace App\Repositories;

use App\Services\BuilderService;
use App\Interfaces\SettingRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class SettingReposiotry implements SettingRepositoryInterface
{
    public function getMany($regionFilters, $model): LengthAwarePaginator
    {
        $paginate = $regionFilters['paginate'] ?? request()->paginate;
        $builder = $model::with('childrenRecursive')->select();

        $this->buildGetManyQueries($regionFilters, $builder);

        builderService::prepareFilters($regionFilters, $builder);
        builderService::prepareSort($regionFilters, $builder);

        return $builder->paginate($paginate);
    }

    private function buildGetManyQueries($regionFilters, $builder)
    {
        $parent_id = $regionFilters['parent_id'];
        $name = $regionFilters['name'];

        if (isset($name)) {
            $builder->where('name', $name);
        }

        if (isset($parent_id)) {
            $builder->where('parent_id', $parent_id);
        }
    }
}