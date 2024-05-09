<?php

namespace App\Http\Resources\Media;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mime_type' => $this->mime_type,
            'model_type' => $this->model_type,
            'model_id' => $this->model_id,
            'uuid' => $this->uuid,
            'collection_name' => $this->uuid,
            'conversions_disk' => $this->conversions_disk,
            'original_url' => $this->original_url,
            'created_at' => $this->created_at,
        ];
    }
}