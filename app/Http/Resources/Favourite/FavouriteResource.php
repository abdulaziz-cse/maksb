<?php

namespace App\Http\Resources\Favourite;

use App\Http\Resources\User\EmbededUserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Project\EmbededProjectResource;

class FavouriteResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user' => $this->user ? new EmbededUserResource($this->user) : null,
            'project' => $this->project ? new EmbededProjectResource($this->project) : null,
        ];
    }
}
