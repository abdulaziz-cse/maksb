<?php

namespace App\Http\Resources\V2\Settings\Category;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V2\Settings\Category\EmbeddedCategoryResource;

class CategoryListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'group' => $this->group ? new EmbeddedCategoryResource($this->group) : null,
            'created_at' => $this->created_at,
        ];
    }
}