<?php

namespace App\Http\Controllers\Api\V1\Favourite;

use App\Http\Controllers\Api\V1\BaseApiController;
use App\Http\Requests\Api\V1\FavouriteRequest;
use App\Services\FavouriteService;
use Illuminate\Http\Request;


class FavouriteController extends BaseApiController
{
    private $service;

    public function __construct(FavouriteService $service)
    {
        parent::__construct();
        $this->service = $service;
    }


    public function index()
    {
        $favourites = $this->service->getList();
        return response()->json($favourites);
    }

    public function store(FavouriteRequest $request)
    {
        $data = $request->validated();
        $favourite =  $this->service->store($data);
        return response()->json($favourite);
    }

    public function destroy(int $id)
    {
        $this->service->destroy($id);
        return response()->json([
            'message' => 'Favourite removed successfully',
        ]);
    }



}
