<?php

namespace App\Http\Resources\V2\Project;

use App\Http\Resources\User\EmbededUserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Settings\Country\EmbededCountryResource;
use App\Http\Resources\Settings\Currency\EmbededCurrencyResource;
use App\Http\Resources\V2\Settings\Category\EmbededCategoryResource;
use App\Http\Resources\Settings\PredefinedValue\EmbeddedPredefinedValueResource;

class ProjectIndexResource extends JsonResource
{
    public function toArray($request): array
    {
        // Parse the JSON strings into associative arrays
        $incoming = json_decode($this->incoming, true);
        $cost = json_decode($this->cost, true);
        $revenue = json_decode($this->revenue, true);
        $expenses = json_decode($this->expenses, true);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'user' => $this->user ? new EmbededUserResource($this->user) : null,
            'type' => $this->type ? new EmbeddedPredefinedValueResource($this->type) : null,
            'category' => $this->category ? new EmbededCategoryResource($this->category) : null,
            'website' => $this->website,
            'establishment_date' => $this->establishment_date,
            'country' => $this->country ? new EmbededCountryResource($this->country) : null,
            'currency' => $this->currency ? new EmbededCurrencyResource($this->currency) : null,
            'other_platform' => $this->other_platform,
            'yearly' => $this->yearly,
            'incoming' => $incoming,
            'cost' => $cost,
            'revenue' => $revenue,
            'expenses' => $expenses,
            'other_assets' => $this->other_assets,
            'is_supported' => $this->is_supported,
            'support' => $this->support,
            'social_media' => $this->social_media,
            'price' => $this->price,
            'current_user_favorite' => $this->currentUserFavorite,
        ];
    }
}
