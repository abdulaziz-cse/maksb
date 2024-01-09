<?php

namespace App\Http\Controllers\Api\V1\Messaging;

use App\Http\Controllers\Api\V1\BaseApiController;
use App\Http\Requests\Api\V1\MessageRequest;
use App\Services\MessagingService;
use Illuminate\Http\Request;

/**
 * @group Messaging
 */
class MessageController extends BaseApiController
{
    protected $messagingService;

    public function __construct(MessagingService $messagingService)
    {
        parent::__construct();
        
        $this->messagingService = $messagingService;
    }

    /**
     * Get messages
     * 
     * @queryParam conversation_id required Conversation id.
     * @queryParam page            Page number for pagination. Example: 2
     * @queryParam perPage         Results per page. Example: 15
     * 
     * @param  \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $filters = $this->validate($request, [
            'conversation_id' => 'required|integer|exists:conversations,id',
            'page' => 'sometimes|integer|min:1',
            'perPage' => 'sometimes|integer|min:5|max:50',
        ]);

        $messages = $this->messagingService->getMessages(
            auth()->user(), $filters
        );

        return response()->json($messages);
    }

    /**
     * Send message
     *
     * @param  \App\Http\Requests\Api\V1\MessageRequest $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(MessageRequest $request)
    {
    	$data = $request->validated();
    	$message = $this->messagingService->sendMessage(auth()->user(), $data);

    	return response()->json($message);
    }
}
