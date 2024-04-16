<?php

namespace App\Http\Resources\Settings\PredefinedValue;

use Illuminate\Http\Resources\Json\JsonResource;

class EmbeddedPredefinedValueResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
        ];
    }
}
