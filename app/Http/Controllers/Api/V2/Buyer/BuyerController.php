<?php

namespace App\Http\Controllers\Api\V2\Buyer;

use App\Models\V2\Buyer\Buyer;
use Illuminate\Http\JsonResponse;
use App\Services\V2\Buyer\BuyerService;
use App\Http\Resources\V2\Buyer\BuyerResource;
use App\Http\Controllers\Api\V2\BaseApiController;
use App\Http\Resources\V2\Buyer\BuyerIndexResource;
use App\Http\Requests\Api\V2\Buyer\BuyerIndexRequest;
use App\Http\Requests\Api\V2\Buyer\BuyerManageRequest;
use App\Http\Requests\Api\V2\Buyer\BuyerUpdateRequest;

class BuyerController extends BaseApiController
{
    public function __construct(private BuyerService $service)
    {
    }

    public function index(BuyerIndexRequest $request): JsonResponse
    {
        $buyerFilters = $request->validated();
        $buyers = $this->service->getMany($buyerFilters);

        return $this->returnDateWithPaginate(
            $buyers,
            'success',
            BuyerIndexResource::class
        );
    }

    public function store(BuyerManageRequest $request): JsonResponse
    {
        $requestData = $request->validated();
        $buyer =  $this->service->create($requestData);

        return $this->returnDate(
            new BuyerResource($buyer),
            'success'
        );
    }

    public function update(BuyerUpdateRequest $request, Buyer $buyer): JsonResponse
    {
        $buyerData = $request->validated();
        $buyer = $this->service->update($buyerData, $buyer);

        return $this->returnDate(
            new BuyerResource($buyer),
            'success'
        );
    }

    public function show(Buyer $buyer): JsonResponse
    {
        return $this->returnDate(
            new BuyerResource($buyer),
            'Buyer data send successfully.'
        );
    }

    public function destroy(Buyer $buyer): JsonResponse
    {
        $this->service->deleteOne($buyer);

        return $this->returnSuccessMessage('Buyer deleted successfully');
    }
}