<?php

namespace App\Http\Resources\V2\Settings\Category;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V2\Settings\Category\CategoryListResource;
use App\Http\Resources\V2\Settings\Category\CategoryTreeResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return $this->relationLoaded('childrenRecursive') ? new CategoryTreeResource($this)
            : new CategoryListResource($this);
    }
}