<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Auth', 'as' => 'auth.'], function () {
    Route::post('register', 'RegisterController@register')
        ->name('register');

    Route::post('login', 'LoginController@login')
        ->name('login');

    Route::post('send-code', 'VerificationController@sendCode')
        ->name('send-code');

    Route::post('verify-code', 'VerificationController@verifyCode')
        ->name('verify-code');

    Route::post('reset-password', 'ResetPasswordController@resetPassword')
        ->name('reset-password');

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
