<?php

namespace App\Http\Controllers\Api\V2\Buyer;

use App\Models\V2\Buyer\Buyer;
use Illuminate\Http\JsonResponse;
use App\Services\Buyer\BuyerService;
use App\Http\Resources\V2\Buyer\BuyerResource;
use App\Http\Resources\V2\Buyer\BuyerIndexResource;
use App\Http\Controllers\Api\V2\BaseApiController;
use App\Http\Requests\Api\V2\Buyer\BuyerIndexRequest;
use App\Http\Requests\Api\V2\Buyer\BuyerManageRequest;

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
        $buyer =  $this->service->createOne($requestData);

        return response()->json($buyer);
    }

    // public function update(ProjectUpdateRequest $request, Project $project): JsonResponse
    // {
    //     $projectData = $request->validated();
    //     $project = $this->service->update($projectData, $project);

    //     return $this->returnDate(
    //         new ProjectResource($project),
    //         'success'
    //     );
    // }

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
