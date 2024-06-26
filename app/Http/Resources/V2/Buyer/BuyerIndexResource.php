<?php

namespace App\Http\Resources\V2\Buyer;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V2\User\EmbeddedUserResource;
use App\Http\Resources\V2\Project\EmbeddedProjectResource;
use App\Http\Resources\V2\Settings\PredefinedValue\EmbeddedPredefinedValueResource;

class BuyerIndexResource extends JsonResource
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
            'user' => $this->user ? new EmbeddedUserResource($this->user) : null,
            'project' => $this->project ? new EmbeddedProjectResource($this->project) : null,
        ];
    }
}
