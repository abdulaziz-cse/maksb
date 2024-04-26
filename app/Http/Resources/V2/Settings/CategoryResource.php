<?php

namespace App\Http\Resources\V2\Settings;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name ?? null,
            'group' => $this->group ? new EmbededCategoryResource($this->group) : null,
            'childerns' => $this->childrenRecursive ? EmbededCategoryResource::collection($this->childrenRecursive) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
