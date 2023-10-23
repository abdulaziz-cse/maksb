<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'User',
    'as' => 'users.',
    'middleware' => 'auth:sanctum',
], function () {
    Route::get('/{id}', 'UserController@getProfile')->name('profile');
    Route::post('/{id}', 'UserController@updateProfile')->name('update');
});
