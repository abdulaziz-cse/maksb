<?php

namespace App\Contracts\Repositories;

use App\Models\Favourite;

interface FavouriteRepositoryInterface
{
    public function store(array $data) :Favourite ;
    public function destroy(int $id);
    public function getList(int $user_id);

}
