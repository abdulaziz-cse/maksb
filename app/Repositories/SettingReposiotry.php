<?php

namespace App\Repositories;

use App\Services\BuilderService;
use App\Interfaces\SettingRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class SettingReposiotry implements SettingRepositoryInterface
{
    public function getMany($resourceFilters, $model): LengthAwarePaginator
    {
        $paginate = $resourceFilters['paginate'] ?? request()->paginate;
        $builder = $model::with('childrenRecursive')->select();

        $this->buildGetManyQueries($resourceFilters, $builder);

        builderService::prepareFilters($resourceFilters, $builder);
        builderService::prepareSort($resourceFilters, $builder);

        return $builder->paginate($paginate);
    }

    private function buildGetManyQueries($resourceFilters, $builder)
    {
        $parent_id = $resourceFilters['parent_id'];
        $name = $resourceFilters['name'];
        $use_parent_id = $resourceFilters['use_parent'];
        $slug = $resourceFilters['slug'];

        if (isset($name)) {
            $builder->where('name', $name);
        }

        if (isset($parent_id)) {
            $builder->where('parent_id', $parent_id);
        }

        if ($use_parent_id) {
            $builder->whereNull('parent_id');
        }

        if (isset($slug)) {
            $builder->where('slug', $slug);
        }
    }
}
