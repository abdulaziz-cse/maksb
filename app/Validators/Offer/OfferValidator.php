<?php

namespace App\Validators\Offer;

use App\Enums\Buyer\BuyerStatus;
use App\Exceptions\ValidationException;
use App\Models\V2\Buyer\Buyer;

class OfferValidator
{

    public static function throwExceptionIfOfferNotPending(Buyer $buyer)
    {
        if ($buyer?->status?->slug != BuyerStatus::PENDING->value) {
            throw new ValidationException('The offer was no longer available: ' . $buyer?->status?->name);
        }
    }

    public static function throwExceptionIfAllOffersPending(bool $isAllOffersPending)
    {
        if ($isAllOffersPending) {
            throw new ValidationException('You have already an offer!');
        }
    }
}
