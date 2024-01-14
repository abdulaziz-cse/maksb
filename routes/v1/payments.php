<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Payment', 'as' => 'payments.'], function() {
	Route::post('/webhook', 'PaymentController@webhook')->name('webhook');

	Route::group(['middleware' => 'auth:sanctum'], function() {
		Route::post('/', 'PaymentController@pay')->name('pay');
		Route::get('/{transactionId}', 'PaymentController@verify')->name('verify');
	});
});
