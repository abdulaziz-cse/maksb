<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Notification\NotificationController;

Route::group([
    // 'namespace' => 'Notification',
    // 'as' => 'notifications.',
    'middleware' => 'auth:sanctum',
], function () {
    // Route::get('/', 'NotificationController@index');
    // Route::get('/unread', 'NotificationController@unread');
    // Route::get('/unread_count', 'NotificationController@unreadCount');
    // Route::patch('/mark_all_read', 'NotificationController@markAllAsRead');
    // Route::put('/{id}/mark_read', 'NotificationController@markRead');

    Route::get('/', [NotificationController::class, 'index']);
    Route::get('/unread', [NotificationController::class, 'unread']);
    Route::get('/unread_count', [NotificationController::class, 'unreadCount']);
    Route::patch('/mark_all_read', [NotificationController::class, 'markAllAsRead']);
    Route::put('/{id}/mark_read', [NotificationController::class, 'markRead']);
});