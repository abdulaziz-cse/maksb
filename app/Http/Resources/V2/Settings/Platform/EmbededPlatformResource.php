<?php

namespace App\Http\Resources\V2\Settings\Platform;

use Illuminate\Http\Resources\Json\JsonResource;

class EmbededPlatformResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
