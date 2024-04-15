<?php

namespace App\Http\Controllers\Api\V1\Favourite;

use App\Traits\GeneralTrait;
use Illuminate\Http\JsonResponse;
use App\Services\favourite\FavouriteService;
use App\Http\Resources\Favourite\FavouriteResource;
use App\Http\Controllers\Api\V1\BaseApiController;
use App\Http\Requests\Api\V1\Favourite\FavouriteIndexRequest;
use App\Http\Requests\Api\V1\Favourite\FavouriteManageRequest;


class FavouriteController extends BaseApiController
{
    use GeneralTrait;

    public function __construct(private FavouriteService $favouriteService)
    {
        parent::__construct();
    }

    public function index(FavouriteIndexRequest $request): JsonResponse
    {
        $favouriteFilters = $request->validated();
        $favourites = $this->favouriteService->getMany($favouriteFilters);

        return $this->returnDateWithPaginate(
            $favourites,
            'success',
            FavouriteResource::class
        );
    }

    public function store(FavouriteManageRequest $request)
    {
        $data = $request->validated();
        $favourite =  $this->favouriteService->store($data);
        return response()->json($favourite);
    }

    public function destroy(int $id)
    {
        $this->favouriteService->destroy($id);
        return response()->json([
            'message' => 'Favourite removed successfully',
        ]);
    }
}
