<?php

namespace App\Http\Resources\V2\Settings;

use Illuminate\Http\Resources\Json\JsonResource;

class EmbededCategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
