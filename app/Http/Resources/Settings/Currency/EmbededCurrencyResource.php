<?php

namespace App\Http\Resources\Settings\Currency;

use Illuminate\Http\Resources\Json\JsonResource;

class EmbededCurrencyResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name ?? null,
        ];
    }
}
