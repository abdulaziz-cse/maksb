<?php

namespace App\Http\Resources\V2\Settings\Region;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V2\Settings\Region\RegionListResource;
use App\Http\Resources\V2\Settings\Region\RegionTreeResource;

class RegionResource extends JsonResource
{
    public function toArray($request)
    {
        return $this->relationLoaded('childrenRecursive') ? new RegionTreeResource($this)
            : new RegionListResource($this);
    }
}