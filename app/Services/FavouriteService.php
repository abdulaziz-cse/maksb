<?php

namespace App\Services;

use App\Contracts\Repositories\FavouriteRepositoryInterface;
use App\Models\Favourite;

class FavouriteService
{
    private $favouriteRepository;

    public function __construct(FavouriteRepositoryInterface $favouriteRepository)
    {
        $this->favouriteRepository = $favouriteRepository;
    }

    public function store(array $data) : Favourite
    {
        $data['user_id'] = auth('sanctum')->user()->id;
        $favourite = $this->favouriteRepository->store($data);
        return $favourite;
    }

    public function destroy($id)
    {
        return $this->favouriteRepository->destroy($id);
    }

    public function getList()
    {
        $user_id = auth('sanctum')->user()->id;
        return $this->favouriteRepository->getList($user_id);
    }


}
