<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Project\ProjectController;

Route::group([
    // 'namespace' => 'Project',
    // 'as' => 'projects.',
    'middleware' => 'auth:sanctum',
], function () {
    // Route::post('/store', 'ProjectController@store')->name('project.store');
    // Route::get('/getlist', 'ProjectController@getListForUser')->name('project.getList');
    // Route::delete('/destroy/{id}', 'ProjectController@destroy')->name('project.destroy');

    // Route::post('/store', [ProjectController::class, 'store'])->name('project.store');
    // Route::get('/getlist', [ProjectController::class, 'getListForUser'])->name('project.getList');
    // Route::delete('/destroy/{id}', [ProjectController::class, 'destroy'])->name('project.destroy');

    Route::apiResource('/projects', ProjectController::class)->only(['index', 'store', 'show', 'destroy']);
});

// Route::group([
//     // 'namespace' => 'Project',
//     // 'as' => 'projects.',
// ], function () {
//     Route::post('/', [ProjectController::class, 'index'])->name('project.index');
//     Route::get('/{id}', [ProjectController::class, 'show'])->name('project.show');
// });
