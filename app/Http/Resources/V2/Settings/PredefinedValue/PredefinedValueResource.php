<?php

namespace App\Http\Resources\V2\Settings\PredefinedValue;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V2\Settings\PredefinedValue\PredefinedValueListResource;
use App\Http\Resources\V2\Settings\PredefinedValue\PredefinedValueTreeResource;

class PredefinedValueResource extends JsonResource
{
    public function toArray($request)
    {
        return $this->relationLoaded('childrenRecursive') ? new PredefinedValueTreeResource($this)
            : new PredefinedValueListResource($this);
    }
}