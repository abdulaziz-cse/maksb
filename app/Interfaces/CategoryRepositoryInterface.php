<?php

namespace App\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface
{
    public function getMany(): LengthAwarePaginator;
}
