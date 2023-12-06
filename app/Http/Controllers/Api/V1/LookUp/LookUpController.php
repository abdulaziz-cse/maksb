<?php

namespace App\Http\Controllers\Api\V1\LookUp;

use App\Http\Controllers\Api\V1\BaseApiController;
use App\Services\LookUpService;
use Illuminate\Http\Request;

class LookUpController extends BaseApiController
{
    private $service;

    public function __construct(LookUpService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function getLookup($lookup)
    {
        if (method_exists($this->service, $lookup)) {
            return response()->json($this->service->$lookup());
        }

        return response()->json([
            'message' => 'Lookup not found',
        ], 404);
    }


}
