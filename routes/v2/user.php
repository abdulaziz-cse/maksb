<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V2\User\UserController;


Route::group(['prefix' => 'v2/user', 'middleware' => ['auth:sanctum']], function () {
    Route::apiResource('/users', UserController::class)->only(['show', 'update', 'destroy']);

    Route::post('/users/photo', [UserController::class, 'updatePhoto']);

    Route::post('/users/update-password', [UserController::class, 'updatePassword']);
});