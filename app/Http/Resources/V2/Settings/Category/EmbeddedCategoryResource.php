<?php

namespace App\Http\Resources\V2\Settings\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class EmbeddedCategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}