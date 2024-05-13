<?php

namespace App\Http\Resources\V2\Buyer;

use Illuminate\Http\Resources\Json\JsonResource;

class EmbededBuyerStatusResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
