<?php

namespace App\Http\Resources\Settings\Country;

use Illuminate\Http\Resources\Json\JsonResource;

class EmbededCountryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name ?? null,
        ];
    }
}
