<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\VerificationController;

Route::group([], function () {
    Route::post('register', [AuthController::class, 'register']);

    Route::post('login', [AuthController::class, 'login']);

    Route::post('reset-password',  [AuthController::class, 'resetPassword']);

    Route::post('send-code', [VerificationController::class, 'sendCode']);

    Route::post('verify-code',  [VerificationController::class, 'verifyCode']);

    Route::middleware('auth:sanctum')->group(function () {
        /**
         * @group Authentication
         * Get current user
         */
        Route::get('/user', function (\Illuminate\Http\Request $request) {
            $user = $request->user();
            $user->load('photo');
            return response()->json($user);
        })->name('user');
    });
});
