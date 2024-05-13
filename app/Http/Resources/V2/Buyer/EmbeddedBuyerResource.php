<?php

namespace App\Http\Resources\V2\Buyer;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Buyer\EmbededBuyerTypeResource;
use App\Http\Resources\Buyer\EmbededBuyerStatusResource;
use App\Http\Resources\V2\Project\EmbeddedProjectResource;

class EmbeddedBuyerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'offer' => $this->offer,
            'message' => $this->message,
            'nda' => $this->nda,
            'law' => $this->law,
            'type' => $this->type ? new EmbededBuyerTypeResource($this->type) : null,
            'status' => $this->status ? new EmbededBuyerStatusResource($this->status) : null,
            'projects' => $this->projects ? EmbeddedProjectResource::collection($this->projects) : null,
        ];
    }
}
