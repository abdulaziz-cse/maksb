<?php

namespace App\Http\Resources\Media;

use Illuminate\Http\Resources\Json\JsonResource;

class EmbededMediaResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name ?? null,
            'mime_type' => $this->mime_type ?? null,
            'collection_name' => $this->uuid ?? null,
            'conversions_disk' => $this->conversions_disk ?? null,
            'original_url' => $this->original_url ?? null,
        ];
    }
}
