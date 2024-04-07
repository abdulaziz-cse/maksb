<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Payment\PaymentController;

Route::group([], function () { //'namespace' => 'Payment', 'as' => 'payments.'
    // Route::post('/webhook', 'PaymentController@webhook')->name('webhook');
    Route::post('/webhook', [PaymentController::class, 'webhook'])->name('webhook');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        // Route::post('/', 'PaymentController@pay')->name('pay');
        // Route::get('/{transactionId}', 'PaymentController@verify')->name('verify');

        Route::post('/', [PaymentController::class, 'pay'])->name('pay');
        Route::get('/{transactionId}', [PaymentController::class, 'verify'])->name('verify');
    });
});