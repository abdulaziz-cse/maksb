<?php

namespace App\Services;

use App\Contracts\Repositories\ProjectRepositoryInterface;
use App\Events\ChatMessage;
use App\Models\User;
use App\Notifications\NewMessage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;
use App\Models\Conversation;
use App\Models\Message;
use Carbon\Carbon;

class MessagingService {

	protected $projectRepository;

	public function __construct(ProjectRepositoryInterface $projectRepository)
	{
		$this->projectRepository = $projectRepository;
	}

	/**
	 * Send message
     *
	 * @param  \Illuminate\Database\Eloquent\Model  $sender
	 * @param  array  $data
     *
	 * @return \Hamedov\Messenger\Models\Message
	 */
	public function sendMessage(User $sender, array $data): Message
	{
        $type = $this->getMessageType($data['message']);

		if (isset($data['conversation_id'])) {
    		// If conversation_id is provided
    		// Send the message directly to the conversation
    		$conversation = $sender->conversations()->where([
    			'conversations.id' => $data['conversation_id']
    		])->first();
    		$message = $sender->sendMessageTo($conversation, $data['message'], null, $type);
    	} else {
    		// Other wise the ad_id must be present
    		// Send the message to the ad provider
    		// and associate the ad with the conversation
    		$ad = $this->projectRepository->getOne($data['project_id']);
    		$provider = $ad->user;

    		if ($provider->id === $sender->id) {
    			throw ValidationException::withMessages([
	        		'message' => 'You cannot send a message to yourself',
	        	]);
    		}

    		// Send the message with params (Recepient, Message, Related Model)
    		$message = $sender->sendMessageTo($provider, $data['message'], $ad, $type);
    	}

        $message->loadMissing('participant', 'media');
        $sender->load('photo');
        $message->participant->setRelation('messageable', $sender);

        broadcast(new ChatMessage($message));

        // We only have one recepient in this app logic
        $recepient = $message->recepients()->first()->messageable;
        $recepient->notify(new NewMessage($message));

        return $message;
	}

    public function getMessageType($message)
    {
        // We will specify the type for our custom type only
        // Otherwise the package will handle the type
        if ( ! is_array($message) || ! isset($message['price'])) {
            return null;
        }

        // This is an offer
        // ['price' => 9789, 'status' => 'pending']
        return 'offer';
    }

	/**
	 * Get user conversations
     *
	 * @param  \Illuminate\Database\Eloquent\Model  $messageable
	 * @param  array  $filters
     *
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getConversations(User $messageable, array $filters): LengthAwarePaginator
	{
		$conversations = $messageable->conversations()
			// ->withCount('participants')
    		->with([
                'relatable', 'relatable.media', 'lastMessage', 'lastMessage.participant.messageable',
                'participants', 'participants.messageable',
                'participants.messageable', 'participants.messageable.photo',
            ])->when(isset($filters['ad_id']), function($query) use ($filters) {
				$query->where('conversations.relatable_id', $filters['ad_id']);
				$query->where('conversations.relatable_type', 'ad');
			})->latest()->paginate($filters['perPage'] ?? 30);

        $conversations->getCollection()->transform(
            function($conversation) use ($messageable) {
                // Get participant entity for the user fetching conversations
                $participant = $conversation->participants
                    ->firstWhere('messageable_id', $messageable->id);
                // Get other participant
                $otherParticipant = $conversation->participants
                    ->firstWhere('messageable_id', '!=', $messageable->id);
                $conversation->otherUser = $otherParticipant
                    ? $otherParticipant->messageable
                    : null;
                // Specify whether this conversation has new messages
                $lastMessageReaders = (array) json_decode($conversation->lastMessage->read_by);
                $conversation->hasNewMessages =
                    $conversation->lastMessage->participant->id != $participant->id &&
                    ( ! isset($lastMessageReaders[$participant->id]) ||
                        $conversation->lastMessage->created_at->gt($participant->last_read));

                // Set related ad image
                if ($conversation->relatable) {
	               	$mainImage = $conversation->relatable->media->first(function ($value, $key) {
						return $value->hasCustomProperty('isMainImage');
					}) ?? $conversation->relatable->media->first();

					$conversation->relatable->setRelation('image', $mainImage);
                }

                return $conversation;
            }
        );

        return $conversations;
	}

	/**
	 * Get conversation messages
	 *
	 * @param  \Illuminate\Database\Eloquent\Model  $messageable
	 * @param  int    $conversation_id
	 * @param  array  $filters
	 *
	 * @return array
	 */
	public function getMessages(Model $messageable, array $filters): LengthAwarePaginator
	{
    	$conversation = $messageable->conversations()->where([
    		'conversations.id' => $filters['conversation_id'] ?? 0,
    	])->first();

    	if ( ! $conversation) {
    		abort(404, 'Conversation not found');
    	}

    	$perPage = $filters['perPage'] ?? 20;
    	$messages = $conversation->messages()->with([
    		'participant', 'participant.messageable', 'media',
            'participant.messageable.photo',
    	])->latest()->paginate($perPage);

    	return $messages;
	}

	/**
	 * Mark conversation as read
	 *
	 * @param  \Illuminate\Database\Eloquent\Model  $messageable
	 * @param  int    $conversation_id [description]
	 *
	 * @return \Hamedov\Messenger\Models\Conversation
	 */
	public function markConversationAsRead(Model $messageable, int $conversation_id): Conversation
	{
		// Get user conversation
		$conversation = $messageable->conversations()->where([
			'conversations.id' => $conversation_id,
		])->firstOrFail();

    	// Get user participant entry for this conversation
    	$participant = $conversation->participants()->where([
    		'messageable_id' => $messageable->id,
    		'messageable_type' => $messageable->getMorphClass(),
    	])->first();

    	$timestamp = Carbon::now();

    	$participant->update(['last_read' => $timestamp]);

    	$conversation->messages()->where('read_by', 'not like', \DB::raw("'%\"".$participant->id."\":%'"))
    		->where('participant_id', '!=', $participant->id)
    		->update([
    			'read_by' => \DB::raw('REPLACE(read_by, \'}\', \'"'.$participant->id.'":"'.$timestamp.'"}\')'),
    		]);

    	return $conversation;
	}

    /**
     * Get message by id
     *
     * @param  int $messageId
     *
     * @return \Hamedov\Messenger\Models\Message $message
     */
    public function getMessage($messageId)
    {
        return Message::findOrFail($messageId);
    }
}
