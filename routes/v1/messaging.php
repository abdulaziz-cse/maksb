<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Messaging\MessageController;
use App\Http\Controllers\Api\V1\Messaging\ConversationController;

Route::group([
    // 'namespace' => 'Messaging',
    // 'as' => 'messaging.',
    'middleware' => 'auth:sanctum',
], function () {
    // Get current user conversations
    // Route::get('/conversations', 'ConversationController@index');
    // // Get current user conversation messages
    // Route::get('/messages', 'MessageController@index');
    // // Mark conversation as read
    // Route::patch('/conversations/{id}/mark_as_read', 'ConversationController@markAsRead');
    // // Send message
    // Route::post('/', 'MessageController@create');



    Route::get('/conversations', [ConversationController::class, 'index']);
    // Get current user conversation messages
    Route::get('/messages', [MessageController::class, 'index']);
    // Mark conversation as read
    Route::patch('/conversations/{id}/mark_as_read', [ConversationController::class, 'markAsRead']);
    // Send message
    Route::post('/', [MessageController::class, 'create']);
});
