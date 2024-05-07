<?php

namespace App\Contracts\Repositories;

use App\Models\Favourite;
use Illuminate\Pagination\LengthAwarePaginator;

interface FavouriteRepositoryInterface
{
    public function getMany($projectFilters): LengthAwarePaginator;

    public function createOne(array $favouriteData): Favourite;

    public function deleteOne(int $id): bool;
}
