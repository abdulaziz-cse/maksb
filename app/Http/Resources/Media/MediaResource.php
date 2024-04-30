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
            'manipulations' => $this->manipulations,
            'custom_properties' => $this->custom_properties,
            'generated_conversions' => $this->generated_conversions,
            'responsive_images' => $this->responsive_images,
            'order_column' => $this->order_column,
            'original_url' => $this->original_url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
