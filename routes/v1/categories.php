<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Category\CategoryController;

Route::group([], function () { //'namespace' => 'Category', 'as' => 'categories.'
    // Route::get('/', 'CategoryController@index')->name('list');
    Route::get('/',  [CategoryController::class, 'index'])->name('list');
});
