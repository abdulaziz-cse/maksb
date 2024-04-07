<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Auth\VerificationController;
use App\Http\Controllers\Api\V1\Auth\ResetPasswordController;

Route::group([], function () { //'namespace' => 'Auth', 'as' => 'auth.'
    // Route::post('register', ['RegisterController@register'])
    //     ->name('register');

    // Route::post('login', 'LoginController@login')
    //     ->name('login');

    // Route::post('send-code', 'VerificationController@sendCode')
    //     ->name('send-code');

    // Route::post('verify-code', 'VerificationController@verifyCode')
    //     ->name('verify-code');

    // Route::post('reset-password', 'ResetPasswordController@resetPassword')
    //     ->name('reset-password');

    Route::post('register', [RegisterController::class, 'register']);

    Route::post('login', [LoginController::class, 'login']);

    Route::post('send-code', [VerificationController::class, 'sendCode']);

    Route::post('verify-code',  [VerificationController::class, 'verifyCode']);

    Route::post('reset-password',  [ResetPasswordController::class, 'resetPassword']);

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
