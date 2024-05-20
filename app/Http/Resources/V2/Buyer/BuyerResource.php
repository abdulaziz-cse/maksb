<?php

namespace App\Http\Resources\V2\Buyer;

use App\Http\Resources\Media\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V2\User\EmbeddedUserResource;
use App\Http\Resources\V2\Project\EmbeddedProjectResource;
use App\Http\Resources\V2\Settings\PredefinedValue\EmbeddedPredefinedValueResource;

class BuyerResource extends JsonResource
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
            'file' => $this->file ? new MediaResource($this->file) : null,
            'projects' => $this->projects ? EmbeddedProjectResource::collection($this->projects) : null,
            'created_at' => $this->created_at,
        ];
    }
}