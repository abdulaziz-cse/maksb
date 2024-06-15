<?php

namespace App\Http\Mappers\Offer;

class OfferMapper
{
    public function toSaveStatusParam(?int $statusId): array
    {
        return [
            'status_id' => $statusId,
        ];
    }
}
