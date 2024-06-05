<?php

namespace App\Http\Resources\V2\Buyer;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V2\Buyer\EmbeddedBuyerResource;
use App\Http\Resources\V2\Project\EmbeddedProjectResource;

class EmbeddedBuyerProjectResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'project' => $this->pivot->project ? new EmbeddedProjectResource($this->pivot->buyer) : null,
            'buyer' => $this->pivot->buyer ? new EmbeddedBuyerResource($this->pivot->buyer) : null,
            'is_accepted' => $this->pivot->is_accepted,
        ];
    }
}