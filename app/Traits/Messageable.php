<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use App\Models\Conversation;
use App\Models\Participant;
use App\Models\Message;


Trait Messageable {

	public function conversations()
	{
		return $this->morphToMany(Conversation::class, 'messageable', 'participants', 'messageable_id', 'conversation_id');
	}

	public function sendMessageTo($recepient, $message, ?Model $related = null, $type = null)
	{
		if (! $recepient instanceof Conversation &&
				$recepient instanceof Model) {
			$conversation = $this->getConversation($recepient, $related);

			if (! $conversation) {
				// Create new conversation
				$conversation = $this->newConversation($recepient, $related);
			}
		} elseif ($recepient instanceof Conversation) {
			// Add message to conversation by any entity
			// First check if this entity is a participant in this conversation
			// If not add it to the conversation
			$conversation = $recepient;
			if (! $conversation->hasParticipant($this)) {
				$this->joinConversation($conversation);
			}
		}

		return $conversation->newMessage($this, $message, $type);
	}

	public function getConversation(Model $otherParty, ?Model $related = null)
	{
		$conversation = $this->conversations()->select([
			'conversations.*', 'p2.id AS other_participant_id'
		])->when($related instanceof Model, function($query) use ($related) {
			// Get the conversation related to this specific model
			$query->where('conversations.relatable_id', $related->id);
			$query->where('conversations.relatable_type', $related->getMorphClass());
		})->when(! $related instanceof Model, function($query) use ($related) {
			// Get the direct conversation between the two parties
			// Not related to any models
			$query->whereNull('conversations.relatable_id');
			$query->whereNull('conversations.relatable_type');
		})->join('participants AS p2', function($join) use ($otherParty) {
			$join->on('p2.conversation_id', '=', 'conversations.id');
			$join->where('p2.messageable_id', '=', $otherParty->id);
			$join->where('p2.messageable_type', '=', $otherParty->getMorphClass());
		})->first();

		// var_dump($conversation);
		// die();

		return $conversation;
	}

	public function newConversation(Model $recepient, ?Model $related = null)
	{
		$conversation = Conversation::create([
			'name' => null,
			'relatable_id' => $related ? $related->id : null,
			'relatable_type' => $related ? $related->getMorphClass() : null,
		]);

		$conversation->participants()->saveMany([
			new Participant([
				'messageable_id' => $this->id,
				'messageable_type' => $this->getMorphClass(),
				'is_admin' => '1',
				'status' => 'active',
			]),
			new Participant([
				'messageable_id' => $recepient->id,
				'messageable_type' => $recepient->getMorphClass(),
			]),
		]);

		return $conversation;
	}

	public function joinConversation(Conversation $conversation, $asAdmin = false)
	{
		$conversation->addParticipant($this, $asAdmin);
	}
}
