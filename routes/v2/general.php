<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V2\General\InquiryController;

Route::prefix('v2/general')->group(function () {

    Route::apiResource('/inquiries', InquiryController::class)->only('store');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::apiResource('/inquiries', InquiryController::class)->only('index', 'show', 'update', 'destroy');
    });
});