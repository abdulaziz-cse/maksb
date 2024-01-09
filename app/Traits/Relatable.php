<?php

namespace App\Traits;

use App\Models\Conversation;

Trait Relatable {

	public function conversations()
	{
		return $this->morphMany(Conversation::class, 'relatable');
	}
}
