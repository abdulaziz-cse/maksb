<?php

namespace App\Http\Controllers\Api\V1\Buyer;

use App\Models\Buyer;
use App\Traits\GeneralTrait;
use Illuminate\Http\JsonResponse;
use App\Services\Buyer\BuyerService;
use App\Http\Resources\Buyer\BuyerResource;
use App\Http\Resources\Buyer\BuyerIndexResource;
use App\Http\Controllers\Api\V1\BaseApiController;
use App\Http\Requests\Api\V1\Buyer\BuyerIndexRequest;
use App\Http\Requests\Api\V1\Buyer\BuyerManageRequest;

class BuyerController extends BaseApiController
{
    use GeneralTrait;

    public function __construct(private BuyerService $buyerService)
    {
        parent::__construct();
    }

    public function index(BuyerIndexRequest $request): JsonResponse
    {
        $buyerFilters = $request->validated();
        $buyers = $this->buyerService->getMany($buyerFilters);

        return $this->returnDateWithPaginate(
            $buyers,
            'success',
            BuyerIndexResource::class
        );
    }

    public function store(BuyerManageRequest $request): JsonResponse
    {
        $requestData = $request->validated();
        $buyer =  $this->buyerService->createOne($requestData);

        return response()->json($buyer);
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
        $this->buyerService->deleteOne($buyer);

        return $this->returnSuccessMessage('Buyer deleted successfully');
    }
}
