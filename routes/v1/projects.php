<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Project',
    'as' => 'projects.',
    'middleware' => 'auth:sanctum',
], function () {
    Route::post('/store', 'ProjectController@store')->name('project.store');
    Route::post('/', 'ProjectController@index')->name('project.index');
    Route::get('/getlist', 'ProjectController@getListForUser')->name('project.getList');
    Route::delete('/destroy/{id}', 'ProjectController@destroy')->name('project.destroy');
});