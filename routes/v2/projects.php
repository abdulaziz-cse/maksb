<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V2\Project\ProjectController;

Route::prefix('v2/project')->group(function () {

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::apiResource('/projects', ProjectController::class)->only(['store', 'update', 'destroy']);
    });

    Route::prefix('/projects')->controller(ProjectController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
    });
});