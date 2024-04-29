<?php

namespace App\Services\V2\Settings;

use App\Models\V2\Settings\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\CategoryRepositoryInterface;

class CategoryService implements CategoryRepositoryInterface
{

    public function getMany(): LengthAwarePaginator
    {
        $paginate = request()->paginate;
        $builder = Category::with('childrenRecursive')->select();


        return $builder->paginate($paginate);
    }
}
