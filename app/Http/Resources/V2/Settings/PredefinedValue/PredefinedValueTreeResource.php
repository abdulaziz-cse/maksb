<?php

namespace App\Http\Resources\V2\Settings\PredefinedValue;

use Illuminate\Http\Resources\Json\JsonResource;

class PredefinedValueTreeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'children' => $this->childrenRecursive->count() ? self::collection($this->childrenRecursive) : null,
        ];
    }
}