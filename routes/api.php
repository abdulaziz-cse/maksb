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
    Route::prefix('users')->group(base_path('routes/v1/users.php'));
    Route::prefix('categories')->group(base_path('routes/v1/categories.php'));
    Route::prefix('lookups')->group(base_path('routes/v1/lookups.php'));
    Route::prefix('projects')->group(base_path('routes/v1/projects.php'));
    Route::prefix('messaging')->group(base_path('routes/v1/messaging.php'));
    Route::prefix('notifications')->group(base_path('routes/v1/notifications.php'));
    Route::prefix('buyers')->group(base_path('routes/v1/buyers.php'));
    Route::prefix('favourites')->group(base_path('routes/v1/favourites.php'));
    Route::prefix('payments')->group(base_path('routes/v1/payments.php'));

});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
