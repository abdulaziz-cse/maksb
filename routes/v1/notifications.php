<?php

use Illuminate\Support\Facades\Route;

Route::group([
	'namespace' => 'Notification',
	'as' => 'notifications.',
	'middleware' => 'auth:sanctum',
], function() {
	Route::get('/', 'NotificationController@index');
	Route::get('/unread', 'NotificationController@unread');
	Route::get('/unread_count', 'NotificationController@unreadCount');
	Route::patch('/mark_all_read', 'NotificationController@markAllAsRead');
	Route::put('/{id}/mark_read', 'NotificationController@markRead');
});
