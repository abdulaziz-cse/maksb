<?php

namespace App\Http\Controllers\Api\V2\Settings;

use Illuminate\Http\JsonResponse;
use App\Models\V2\Settings\PredefinedValue;
use App\Http\Controllers\Api\V2\BaseApiController;
use App\Services\V2\Settings\PredefinedValueService;
use App\Http\Resources\Settings\PredefinedValue\PredefinedValueResource;

class PredefinedValueController extends BaseApiController
{
    public function __construct(private PredefinedValueService $predefinedValueService)
    {
    }

    public function show(PredefinedValue $predefinedValue): JsonResponse
    {
        return $this->returnDate(
            new PredefinedValueResource($predefinedValue),
            'success'
        );
    }
}