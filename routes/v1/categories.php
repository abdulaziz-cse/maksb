<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Category', 'as' => 'categories.'], function () {
    Route::get('/', 'CategoryController@index')->name('list');
});
