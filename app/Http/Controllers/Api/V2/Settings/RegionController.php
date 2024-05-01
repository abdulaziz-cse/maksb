<?php

namespace App\Http\Controllers\Api\V2\Settings;

use Illuminate\Http\JsonResponse;
use App\Models\V2\Settings\Region;
use App\Services\V2\Settings\RegionService;
use App\Http\Controllers\Api\V2\BaseApiController;
use App\Http\Resources\V2\Settings\Region\RegionResource;
use App\Http\Requests\Api\V2\Settings\Region\RegionIndexRequest;

class RegionController extends BaseApiController
{
    public function __construct(private RegionService $regionService)
    {
    }

    public function index(RegionIndexRequest $request): JsonResponse
    {
        $regionFilters = $request->validated();
        $regions = $this->regionService->getMany($regionFilters);

        return $this->returnDateWithPaginate(
            $regions,
            'success',
            RegionResource::class
        );
    }

    public function show(Region $region): JsonResponse
    {
        return $this->returnDate(
            new RegionResource($region),
            'success'
        );
    }
}