<?php

namespace App\Http\Resources\V2\Settings\PredefinedValue;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V2\Settings\PredefinedValue\EmbeddedPredefinedValueResource;

class PredefinedValueListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'group' => $this->group ? new EmbeddedPredefinedValueResource($this->group) : null,
            'created_at' => $this->created_at,
        ];
    }
}