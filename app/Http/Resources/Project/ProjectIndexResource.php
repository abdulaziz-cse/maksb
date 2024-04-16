<?php

namespace App\Http\Resources\Project;

use App\Http\Resources\User\EmbededUserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Settings\Country\EmbededCountryResource;
use App\Http\Resources\Settings\Currency\EmbededCurrencyResource;
use App\Http\Resources\Settings\PredefinedValue\EmbeddedPredefinedValueResource;

class ProjectIndexResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name ?? null,
            'user' => $this->user ? new EmbededUserResource($this->user) : null,
            'type' => $this->type ? new EmbeddedPredefinedValueResource($this->type) : null,
            'category' => $this->category ? new CategoryResource($this->category) : null,
            'website' => $this->website ?? null,
            'establishment_date' => $this->establishment_date ?? null,
            'country' => $this->country ? new EmbededCountryResource($this->country) : null,
            'other_platform' => $this->other_platform ?? null,
            'currency' => $this->currency ? new EmbededCurrencyResource($this->currency) : null,
            'yearly' => $this->yearly ?? null,
            'incoming' => $this->incoming ?? null,
            'cost' => $this->cost ?? null,
            'revenue' => $this->revenue ?? null,
            'expenses' => $this->expenses ?? null,
            'other_assets' => $this->other_assets ?? null,
            'is_supported' => $this->is_supported ?? null,
            'support' => $this->support ?? null,
            'social_media' => $this->social_media ?? null,
        ];
    }
}
