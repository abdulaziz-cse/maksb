<?php

namespace App\Http\Resources\V2\Buyer;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V2\Settings\PredefinedValue\EmbeddedPredefinedValueResource;

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
            'type' => $this->type ? new EmbeddedPredefinedValueResource($this->type) : null,
            'status' => $this->status ? new EmbeddedPredefinedValueResource($this->status) : null,
        ];
    }
}
