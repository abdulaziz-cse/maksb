<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Project\ProjectController;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('/projects', ProjectController::class)->only(['index', 'store', 'show', 'destroy']);
});

Route::prefix('/projects/data')->controller(ProjectController::class)->group(function () {
    Route::get('/all', 'getAll');
    Route::get('/{id}', 'getOne');
});
