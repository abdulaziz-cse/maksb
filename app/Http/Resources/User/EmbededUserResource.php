<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class EmbededUserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name ?? null,
            'email' => $this->email ?? null,
            'phone' => $this->phone ?? null,
            'photo' => $this->photo ?? null,
            'about' => $this->about ?? null,
            'phone_verified_at' => $this->phone_verified_at ?? null,
            'email_verified_at' => $this->email_verified_at ?? null,
        ];
    }
}
