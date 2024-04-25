<?php

namespace App\Services\favourite;

use App\Constants\App;
use App\Models\Favourite;
use App\Services\BuilderService;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Contracts\Repositories\FavouriteRepositoryInterface;

class FavouriteService implements FavouriteRepositoryInterface
{
    public function getMany($projectFilters): LengthAwarePaginator
    {
        $paginate = $projectFilters['paginate'] ?? request()->paginate;
        $builder = Favourite::with('user');
        $this->buildGetManyQuery($projectFilters, $builder);

        // Prepare sort & search filter if provided
        BuilderService::prepareFilters($projectFilters, $builder);
        BuilderService::prepareSort($projectFilters, $builder);

        return $builder->paginate($paginate);
    }

    private function buildGetManyQuery($projectFilters, $builder)
    {
        $user_id = $projectFilters['user_id'];
        $project_id = $projectFilters['project_id'];

        if (isset($user_id)) {
            $builder->where('user_id', $user_id);
        }

        if (isset($project_id)) {
            $builder->where('project_id', $project_id);
        }
    }

    public function createOne(array $favouriteData): Favourite
    {
        $favouriteData['user_id'] = auth(App::API_GUARD)->user()->id;

        return Favourite::create($favouriteData)->fresh();
    }

    public function deleteOne(int $id): bool
    {
        $user = auth(App::API_GUARD)->user();

        return $user->favourites()->detach($id);
    }
}
