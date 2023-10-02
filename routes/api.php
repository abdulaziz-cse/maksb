<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group(['prefix' => 'v1', 'as' => 'api.v1.', 'namespace' => 'V1'], function () {
    Route::prefix('auth')->group(base_path('routes/v1/auth.php'));

});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
