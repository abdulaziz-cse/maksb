<?php

namespace App\Http\Resources\V2\Settings\Region;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V2\Settings\Region\EmbeddedRegionResource;

class RegionTreeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'group' => $this->group ? new EmbeddedRegionResource($this->group) : null,
            'children' => $this->childrenRecursive->count() ? self::collection($this->childrenRecursive) : null,
        ];
    }
}