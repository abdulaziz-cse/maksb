<?php

namespace App\Http\Resources\V2\User;

use App\Http\Resources\Media\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V2\Settings\PredefinedValue\EmbeddedPredefinedValueResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'phone_verified_at' => $this->phone_verified_at,
            'email_verified_at' => $this->email_verified_at,
            'type' => $this->type ? new EmbeddedPredefinedValueResource($this->type) : null,
            'about' => $this->about,
            'purchase_purpose' => $this->purchase_purpose,
            'favorite_value' => $this->favorite_value,
            'profession' => $this->profession,
            'owner_of' => $this->owner_of,
            'portfolio' => $this->portfolio,
            'website' => $this->website,
            'photo' => $this->photo ? new MediaResource($this->photo) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}