<?php

namespace App\Http\Resources\Buyer;

use App\Http\Resources\User\EmbededUserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Buyer\EmbededBuyerTypeResource;
use App\Http\Resources\Buyer\EmbededBuyerStatusResource;
use App\Http\Resources\Project\EmbededProjectResource;

class BuyerIndexResource extends JsonResource
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
            'user' => $this->user ? new EmbededUserResource($this->user) : null,
            'projects' => $this->projects ? EmbededProjectResource::collection($this->projects) : null,
        ];
    }
}
