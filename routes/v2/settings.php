<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V2\Settings\{
    RegionController,
    CategoryController,
    PredefinedValueController,
};

Route::group(['prefix' => 'v2/settings', 'middleware' => ['auth:sanctum']], function () {
    Route::apiResource('/predefined-values', PredefinedValueController::class)->only(['index', 'show']);

    Route::apiResource('/categories', CategoryController::class)->only(['index', 'show']);

    Route::apiResource('/regions', RegionController::class)->only(['index', 'show']);
});