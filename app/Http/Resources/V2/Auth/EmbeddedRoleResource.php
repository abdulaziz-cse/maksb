<?php

namespace App\Http\Resources\V2\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class EmbeddedRoleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
