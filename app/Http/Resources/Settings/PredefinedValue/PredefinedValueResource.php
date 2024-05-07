<?php

namespace App\Http\Resources\Settings\PredefinedValue;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Settings\PredefinedValue\EmbeddedPredefinedValueResource;

class PredefinedValueResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'group' => $this->group ? new EmbeddedPredefinedValueResource($this->group) : null,
        ];
    }
}