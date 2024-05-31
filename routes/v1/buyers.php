<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Buyer\BuyerController;

Route::group(['middleware' => 'auth:sanctum'], function () {
    // Route::apiResource('/buyers', BuyerController::class)->only(['index', 'store', 'show', 'destroy']);
});