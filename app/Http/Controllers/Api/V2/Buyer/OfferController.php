<?php

namespace App\Http\Controllers\Api\V2\Buyer;

use App\Models\V2\Buyer\Buyer;
use Illuminate\Http\JsonResponse;
use App\Services\V2\Buyer\OfferService;
use App\Http\Resources\V2\Buyer\BuyerResource;
use App\Http\Controllers\Api\V2\BaseApiController;
use App\Http\Requests\Api\V2\Buyer\UpdateStatusRequest;

class OfferController extends BaseApiController
{
    public function __construct(private OfferService $service)
    {
    }

    public function updateStatus(UpdateStatusRequest $request, Buyer $buyer): JsonResponse
    {
        $requestData = $request->validated();
        $buyer =  $this->service->updateStatus($requestData, $buyer);

        return $this->returnDate(
            new BuyerResource($buyer),
            'success'
        );
    }
}