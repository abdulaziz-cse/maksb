<?php

namespace App\Http\Resources\V2\Project;

use App\Http\Resources\Media\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V2\User\EmbeddedUserResource;
use App\Http\Resources\V2\Buyer\EmbeddedBuyerResource;
use App\Http\Resources\V2\Settings\Asset\AssetResource;
use App\Http\Resources\Settings\Currency\EmbededCurrencyResource;
use App\Http\Resources\V2\Settings\Region\EmbeddedRegionResource;
use App\Http\Resources\V2\Settings\Platform\EmbededPlatformResource;
use App\Http\Resources\V2\Settings\Category\EmbeddedCategoryResource;
use App\Http\Resources\V2\Settings\RevenueSource\EmbededRevenueSourceResource;
use App\Http\Resources\V2\Settings\PredefinedValue\EmbeddedPredefinedValueResource;

class ProjectResource extends JsonResource
{
    public function toArray($request): array
    {
        // Parse the JSON strings into associative arrays
        $incoming = json_decode($this->incoming, true);
        $cost = json_decode($this->cost, true);
        $revenue = json_decode($this->revenue, true);
        $expenses = json_decode($this->expenses, true);
        $social = json_decode($this->social_media, true);
        $billing = json_decode($this->billing_info, true);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'user' => $this->user ? new EmbeddedUserResource($this->user) : null,
            'type' => $this->type ? new EmbeddedPredefinedValueResource($this->type) : null,
            'category' => $this->category ? new EmbeddedCategoryResource($this->category) : null,
            'website' => $this->website,
            'establishment_date' => $this->establishment_date,
            'country' => $this->region ? new EmbeddedRegionResource($this->region) : null,
            'currency' => $this->currency ? new EmbededCurrencyResource($this->currency) : null,
            'yearly' => $this->yearly,
            'incoming' => $incoming,
            'cost' => $cost,
            'revenue' => $revenue,
            'expenses' => $expenses,
            'other_assets' => $this->other_assets,
            'is_supported' => $this->is_supported,
            'support' => $this->support,
            'social_media' => $social,
            'email_subscribers' => $this->email_subscribers,
            'other_social_media' => $this->other_social_media,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'video_url' => $this->video_url,
            'price' => $this->price,
            'package_id' => $this->package_id,
            'billing_info' => $billing,
            'isFavorite' => $this->isFavorite,
            'images' => $this->images ? MediaResource::collection($this->images) : null,
            'attachments' => $this->attachments ? MediaResource::collection($this->attachments) : null,
            'revenue_sources' => $this->revenueSources ? EmbededRevenueSourceResource::collection($this->revenueSources) : null,
            'platforms' => $this->platforms ? EmbededPlatformResource::collection($this->platforms) : null,
            'other_platform' => $this->other_platform,
            'assets' => $this->assets ? AssetResource::collection($this->assets) : null,
            'current_user_favorite' => $this->currentUserFavorite,
            'buyers' => $this->buyers ? EmbeddedBuyerResource::collection($this->buyers) : null,
            'created_at' => $this->created_at,
        ];
    }
}