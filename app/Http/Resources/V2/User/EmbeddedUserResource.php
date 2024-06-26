<?php

namespace App\Http\Resources\V2\User;

use Illuminate\Http\Resources\Json\JsonResource;

class EmbeddedUserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'photo' => $this->photo,
            'about' => $this->about,
            'phone_verified_at' => $this->phone_verified_at,
            'email_verified_at' => $this->email_verified_at,
        ];
    }
}