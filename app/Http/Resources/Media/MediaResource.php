<?php

namespace App\Http\Resources\Media;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name ?? null,
            'mime_type' => $this->mime_type ?? null,
            'model_type' => $this->model_type ?? null,
            'model_id' => $this->model_id ?? null,
            'uuid' => $this->uuid ?? null,
            'collection_name' => $this->uuid ?? null,
            'conversions_disk' => $this->conversions_disk ?? null,
            'manipulations' => $this->manipulations ?? null,
            'custom_properties' => $this->custom_properties ?? null,
            'generated_conversions' => $this->generated_conversions ?? null,
            'responsive_images' => $this->responsive_images ?? null,
            'order_column' => $this->order_column ?? null,
            'preview_url' => $this->preview_url ?? null,
            'original_url' => $this->original_url ?? null,
            'created_at' => $this->created_at ?? null,
            'updated_at' => $this->updated_at ?? null,
        ];
    }
}
