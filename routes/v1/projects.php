<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Project\ProjectController;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('/projects', ProjectController::class)->only(['store', 'destroy']);
});

Route::prefix('/projects')->controller(ProjectController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
});
