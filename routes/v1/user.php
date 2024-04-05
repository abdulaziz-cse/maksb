<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\User\UserController;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('/users', UserController::class)->only(['show', 'update']);
});
