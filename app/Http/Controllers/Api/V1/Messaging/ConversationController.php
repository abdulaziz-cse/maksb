<?php

namespace App\Http\Controllers\Api\V1\Messaging;

use App\Http\Controllers\Api\V1\BaseApiController;
//use App\Http\Requests\MessagingRequest;
use App\Services\MessagingService;
use Illuminate\Http\Request;

/**
 * @group Messaging
 */
class ConversationController extends BaseApiController
{
    protected $messagingService;

    public function __construct(MessagingService $messagingService)
    {
        parent::__construct();

        $this->messagingService = $messagingService;
    }

    /**
     * Get conversations
     *
     * @queryParam ad_id Ad id to fetch conversations for.
     * @queryParam page Page number for pagination Example: 2
     * @queryParam perPage Results to fetch per page Example: 15
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $conversations = $this->messagingService->getConversations(auth()->user(), $request->all());

    	return response()->json($conversations);
    }

    /**
     * Mark conversation as read
     *
     * @queryParam conversation_id required Conversation to mark as read.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $conversationId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(Request $request, $conversationId)
    {
    	$conversation = $this->messagingService->markConversationAsRead(auth()->user(), (int) $conversationId);

    	return response()->json($conversation);
    }
}
