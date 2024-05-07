<?php

namespace App\Http\Resources\V2\Settings\Region;

use Illuminate\Http\Resources\Json\JsonResource;

class EmbeddedRegionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}