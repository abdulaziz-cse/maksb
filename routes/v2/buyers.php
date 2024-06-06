<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V2\Buyer\BuyerController;
use App\Http\Controllers\Api\V2\Buyer\OfferController;

Route::group(['prefix' => 'v2/buyer', 'middleware' => 'auth:sanctum'], function () {
    Route::apiResource('/buyers', BuyerController::class);

    Route::patch('/buyers/{buyer}/status', [OfferController::class, 'updateStatus']);
});