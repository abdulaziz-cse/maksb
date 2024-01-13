<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Buyer',
    'as' => 'buyers.',
    'middleware' => 'auth:sanctum',
], function () {
    Route::post('/store-offer', 'BuyerController@store')->name('buyer.store');
});
