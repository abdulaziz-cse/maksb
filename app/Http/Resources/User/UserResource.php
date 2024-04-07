<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name ?? null,
            'email' => $this->email ?? null,
            'phone' => $this->phone ?? null,
            'phone_verified_at' => $this->phone_verified_at ?? null,
            'type_id' => $this->type_id ?? null,
            'about' => $this->about ?? null,
            'purchase_purpose' => $this->purchase_purpose ?? null,
            'favorite_value' => $this->favorite_value ?? null,
            'profession' => $this->profession ?? null,
            'owner_of' => $this->owner_of ?? null,
            'portfolio' => $this->portfolio ?? null,
            'website' => $this->website ?? null,
            'photo' => $this->photo ?? null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at ?? null,
        ];
    }
}
