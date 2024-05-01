<?php

namespace App\Http\Resources\V2\Settings\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryTreeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'children' => $this->childrenRecursive->count() ? self::collection($this->childrenRecursive) : null,
        ];
    }
}