<?php

namespace App\Http\Controllers\Api\V2\Settings;

use App\Traits\GeneralTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Settings\PredefinedValue;
use App\Services\V2\Settings\PredefinedValueService;
use App\Http\Resources\Settings\PredefinedValue\PredefinedValueResource;

class PredefinedValueController extends Controller
{
    use GeneralTrait;

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
