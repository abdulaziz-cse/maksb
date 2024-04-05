<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'username' => $this->username,
            'phone_verified_at' => $this->phone_verified_at,
            'type_id' => $this->type_id,
            'about' => $this->about,
            'purchase_purpose' => $this->purchase_purpose,
            'favorite_value' => $this->favorite_value,
            'profession' => $this->profession,
            'owner_of' => $this->owner_of,
            'portfolio' => $this->portfolio,
            'website' => $this->website,
            'photo' => $this->photo,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
