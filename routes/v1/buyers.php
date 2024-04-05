<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Buyer\BuyerController;

Route::group([
    // 'namespace' => 'Buyer',
    // 'as' => 'buyers.',
    'middleware' => 'auth:sanctum',
], function () {
    // Route::post('/store-offer', 'BuyerController@store')->name('buyer.store');
    // Route::get('/getlist', 'BuyerController@getListForUser')->name('buyer.getList');
    // Route::get('/{id}', 'BuyerController@show')->name('buyer.show');

    Route::post('/store-offer',  [BuyerController::class, 'store'])->name('buyer.store');
    Route::get('/getlist', [BuyerController::class, 'getListForUser'])->name('buyer.getList');
    Route::get('/{id}', [BuyerController::class, 'show'])->name('buyer.show');
});
