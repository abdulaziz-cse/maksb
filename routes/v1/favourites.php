<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Favourite',
    'as' => 'favourites.',
    'middleware' => 'auth:sanctum',
], function () {
    Route::post('/save', 'FavouriteController@store')->name('favourite.store');
    Route::get('/getlist', 'FavouriteController@index')->name('favourite.index');
    Route::delete('/{id}', 'FavouriteController@destroy')->name('favourite.destroy');
});
