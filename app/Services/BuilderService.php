<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;

class BuilderService
{
    public static function prepareFilters($request, Builder $builder): void
    {
        $search_values = $request['search_values'];
        $search_keys = $request['search_keys'];
        $search_value = $request['search_value'];

        if (isset($search_values) || isset($search_value)) {
            $builder->search($search_values, $search_keys, $search_value);
        }
    }

    public static function prepareSort($request, Builder $builder): void
    {
        $sort_by = $request['sort_by'];
        $sort_type = $request['sort_type'];

        if ($sort_by && $sort_type) {
            $builder->sort($sort_by, $sort_type);
        }
    }
}
