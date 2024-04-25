<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V2\Settings\PredefinedValueController;

Route::group(['prefix' => 'v2/settings', 'middleware' => ['auth:sanctum']], function () {
    Route::apiResource('/predefined-values', PredefinedValueController::class)->only(['show']);
});
