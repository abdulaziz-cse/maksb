<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Favourite\FavouriteController;

Route::group([
    // 'namespace' => 'Favourite',
    // 'as' => 'favourites.',
    'middleware' => 'auth:sanctum',
], function () {
    // Route::post('/save', 'FavouriteController@store')->name('favourite.store');
    // Route::get('/getlist', 'FavouriteController@index')->name('favourite.index');
    // Route::delete('/{id}', 'FavouriteController@destroy')->name('favourite.destroy');

    Route::post('/save', [FavouriteController::class, 'store'])->name('favourite.store');
    Route::get('/getlist', [FavouriteController::class, 'index'])->name('favourite.index');
    Route::delete('/{id}', [FavouriteController::class, 'destroy'])->name('favourite.destroy');
});
