<?php

namespace App\Http\Controllers\Api\V1\Buyer;

use App\Http\Controllers\Api\V1\BaseApiController;
use App\Http\Requests\Api\V1\BuyerRequest;
use App\Services\BuyerService;
use Illuminate\Http\Request;


class BuyerController extends BaseApiController
{
    private $service;

    public function __construct(BuyerService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function store(BuyerRequest $request)
    {
        $data = $request->validated();
        $buyer =  $this->service->store($data);
        return response()->json($buyer);
    }

    public function getListForUser(Request $request)
    {
        $user_id = $request->user()->id;
        $buyers = $this->service->getList($user_id);
        return response()->json($buyers);
    }

    public function show(int $id)
    {
        $buyer = $this->service->show($id);
        return response()->json($buyer);
    }

}
