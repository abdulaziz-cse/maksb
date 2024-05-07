<?php

namespace App\Http\Resources\V2\Settings\RevenueSource;

use Illuminate\Http\Resources\Json\JsonResource;

class EmbededRevenueSourceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
