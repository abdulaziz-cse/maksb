<?php

namespace App\Http\Controllers\Api\V2\Settings;

use Illuminate\Http\JsonResponse;
use App\Models\V2\Settings\PredefinedValue;
use App\Http\Controllers\Api\V2\BaseApiController;
use App\Services\V2\Settings\PredefinedValueService;
use App\Http\Resources\V2\Settings\PredefinedValue\PredefinedValueResource;
use App\Http\Requests\Api\V2\Settings\PredefinedValue\PredefinedValueIndexRequest;

class PredefinedValueController extends BaseApiController
{
    public function __construct(private PredefinedValueService $service)
    {
    }

    public function index(PredefinedValueIndexRequest $request): JsonResponse
    {
        $categoryFilters = $request->validated();
        $regions = $this->service->getMany($categoryFilters);

        return $this->returnDateWithPaginate(
            $regions,
            'success',
            PredefinedValueResource::class
        );
    }

    public function show(PredefinedValue $predefinedValue): JsonResponse
    {
        return $this->returnDate(
            new PredefinedValueResource($predefinedValue),
            'success'
        );
    }
}