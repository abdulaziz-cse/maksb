<?php

namespace App\Http\Resources\V2\Project;

use App\Http\Resources\Media\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Settings\Currency\EmbededCurrencyResource;
use App\Http\Resources\V2\Settings\Category\EmbeddedCategoryResource;
use App\Http\Resources\V2\Settings\RevenueSource\EmbededRevenueSourceResource;
use App\Http\Resources\Settings\PredefinedValue\EmbeddedPredefinedValueResource;

class EmbeddedProjectResource extends JsonResource
{
    public function toArray($request): array
    {
        $cost = json_decode($this->cost, true);
        $revenue = json_decode($this->revenue, true);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type ? new EmbeddedPredefinedValueResource($this->type) : null,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'revenue' => $revenue,
            'revenue_sources' => $this->revenueSources ? EmbededRevenueSourceResource::collection($this->revenueSources) : null,
            'price' => $this->price,
            'cost' => $cost,
            'images' => $this->images ? MediaResource::collection($this->images) : null,
            'category' => $this->category ? new EmbeddedCategoryResource($this->category) : null,
            'currency' => $this->currency ? new EmbededCurrencyResource($this->currency) : null,
        ];
    }
}
