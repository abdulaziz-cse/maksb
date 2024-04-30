<?php

namespace App\Http\Resources\Media;

use Illuminate\Http\Resources\Json\JsonResource;

class EmbededMediaResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mime_type' => $this->mime_type,
            'collection_name' => $this->uuid,
            'conversions_disk' => $this->conversions_disk,
            'original_url' => $this->original_url,
        ];
    }
}
