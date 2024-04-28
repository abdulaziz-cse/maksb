<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Favourite\FavouriteController;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('/favourites', FavouriteController::class)->only(['index', 'store', 'destroy']);
});
