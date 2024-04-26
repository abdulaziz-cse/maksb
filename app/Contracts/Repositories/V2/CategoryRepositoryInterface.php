<?php

namespace App\Contracts\Repositories\V2;

use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface
{
    public function getMany(): LengthAwarePaginator;
}
