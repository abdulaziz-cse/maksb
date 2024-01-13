<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Buyer',
    'as' => 'buyers.',
    'middleware' => 'auth:sanctum',
], function () {
    Route::post('/store-offer', 'BuyerController@store')->name('buyer.store');
    Route::get('/getlist', 'BuyerController@getListForUser')->name('buyer.getList');
    Route::get('/{id}', 'BuyerController@show')->name('buyer.show');
});
