<?php

namespace App\Http\Resources\V2\Project;

use App\Http\Resources\Media\MediaResource;
use App\Http\Resources\User\EmbededUserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Buyer\EmbeddedBuyerResource;
use App\Http\Resources\Settings\Country\EmbededCountryResource;
use App\Http\Resources\Settings\Currency\EmbededCurrencyResource;
use App\Http\Resources\Settings\PredefinedValue\EmbeddedPredefinedValueResource;

class ProjectResource extends JsonResource
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
            'email_subscribers' => $this->email_subscribers ?? null,
            'other_social_media' => $this->other_social_media ?? null,
            'short_description' => $this->short_description ?? null,
            'description' => $this->description ?? null,
            'video_url' => $this->video_url ?? null,
            'price' => $this->price ?? null,
            'package_id' => $this->package_id ?? null,
            'billing_info' => $this->billing_info ?? null,
            'isFavorite' => $this->isFavorite ?? null,
            'images' => $this->images ? MediaResource::collection($this->images) : null,
            'attachments' => $this->attachments ? MediaResource::collection($this->attachments) : null,
            'revenue_sources' => $this->revenueSources ?? null,
            'platforms' => $this->platforms ?? null,
            'assets' => $this->assets ?? null,
            'current_user_favorite' => $this->currentUserFavorite ?? null,
            'buyers' => $this->buyers ? EmbeddedBuyerResource::collection($this->buyers) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at ?? null,
        ];
    }
}
