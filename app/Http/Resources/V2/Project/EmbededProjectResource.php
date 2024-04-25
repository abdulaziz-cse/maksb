<?php

namespace App\Http\Resources\V2\Project;

use App\Http\Resources\Media\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Settings\Currency\EmbededCurrencyResource;
use App\Http\Resources\Settings\PredefinedValue\EmbeddedPredefinedValueResource;

class EmbededProjectResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type ? new EmbeddedPredefinedValueResource($this->type) : null,
            'short_description' => $this->short_description ?? null,
            'description' => $this->description ?? null,
            'revenue' => $this->revenue ?? null,
            'revenue_sources' => $this->revenueSources ?? null,
            'price' => $this->price ?? null,
            'cost' => $this->cost ?? null,
            'images' => $this->images ? MediaResource::collection($this->images) : null,
            'category' => $this->category ? new CategoryResource($this->category) : null,
            'currency' => $this->currency ? new EmbededCurrencyResource($this->currency) : null,
        ];
    }
}