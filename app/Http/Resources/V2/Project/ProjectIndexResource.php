<?php

namespace App\Http\Resources\V2\Project;

use App\Http\Resources\Media\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;
// use App\Http\Resources\V2\User\EmbeddedUserResource;
use App\Http\Resources\Settings\Currency\EmbededCurrencyResource;
use App\Http\Resources\V2\Settings\Category\EmbeddedCategoryResource;
use App\Http\Resources\V2\Settings\Region\EmbeddedProjectRegionResource;
use App\Http\Resources\V2\Settings\RevenueSource\EmbededRevenueSourceResource;
use App\Http\Resources\V2\Settings\PredefinedValue\EmbeddedPredefinedValueResource;

class ProjectIndexResource extends JsonResource
{
    public function toArray($request): array
    {
        // Parse the JSON strings into associative arrays
        $incoming = json_decode($this->incoming, true);
        $cost = json_decode($this->cost, true);
        $revenue = json_decode($this->revenue, true);
        // $expenses = json_decode($this->expenses, true);
        // $social = json_decode($this->social_media, true);

        return [
            'id' => $this->id,
            'name' => $this->name,
            // 'user' => $this->user ? new EmbeddedUserResource($this->user) : null,
            'type' => $this->type ? new EmbeddedPredefinedValueResource($this->type) : null,
            'category' => $this->category ? new EmbeddedCategoryResource($this->category) : null,
            // 'website' => $this->website,
            // 'establishment_date' => $this->establishment_date,
            'country' => $this->region ? new EmbeddedProjectRegionResource($this->region) : null,
            'currency' => $this->currency ? new EmbededCurrencyResource($this->currency) : null,
            'other_platform' => $this->other_platform,
            'yearly' => $this->yearly,
            'incoming' => $incoming,
            'cost' => $cost,
            'revenue' => $revenue,
            // 'expenses' => $expenses,
            'other_assets' => $this->other_assets,
            // 'is_supported' => $this->is_supported,
            'isFavorite' => $this->isFavorite,
            'support' => $this->support,
            // 'social_media' => $social,
            'price' => $this->price,
            'images' => $this->images ? MediaResource::collection($this->images) : null,
            'revenue_sources' => $this->revenueSources ? EmbededRevenueSourceResource::collection($this->revenueSources) : null,
            // 'current_user_favorite' => $this->currentUserFavorite,
        ];
    }
}