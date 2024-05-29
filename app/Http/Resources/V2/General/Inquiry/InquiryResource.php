<?php

namespace App\Http\Resources\V2\General\Inquiry;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V2\Settings\PredefinedValue\EmbeddedPredefinedValueResource;

class InquiryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'message' => $this->message,
            'status' => $this->status ? new EmbeddedPredefinedValueResource($this->status) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}