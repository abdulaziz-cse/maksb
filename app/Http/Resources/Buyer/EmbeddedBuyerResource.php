<?php

namespace App\Http\Resources\Buyer;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Buyer\EmbededBuyerTypeResource;
use App\Http\Resources\Project\EmbededProjectResource;
use App\Http\Resources\Buyer\EmbededBuyerStatusResource;

class EmbeddedBuyerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'offer' => $this->offer ?? null,
            'message' => $this->message ?? null,
            'nda' => $this->nda ?? null,
            'law' => $this->law ?? null,
            'type' => $this->type ? new EmbededBuyerTypeResource($this->type) : null,
            'status' => $this->status ? new EmbededBuyerStatusResource($this->status) : null,
            'projects' => $this->projects ? EmbededProjectResource::collection($this->projects) : null,
        ];
    }
}