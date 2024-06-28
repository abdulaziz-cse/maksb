<?php

namespace App\Validators\Offer;

use App\Enums\Buyer\BuyerStatus;
use App\Enums\Project\ProjectStatus;
use App\Exceptions\ValidationException;
use App\Models\V2\Buyer\Buyer;
use App\Models\V2\Project;

class OfferValidator
{
    public static function throwExceptionIfOfferNotPending(Buyer $buyer)
    {
        if (
            $buyer?->status?->slug != BuyerStatus::PENDING->value ||
            $buyer?->project?->status?->slug != ProjectStatus::OPEN->value
        ) {
            throw new ValidationException('The offer was no longer available: ' . $buyer?->status?->name);
        }
    }

    public static function throwExceptionIfAllOffersPending(bool $isAllOffersPending)
    {
        if ($isAllOffersPending) {
            throw new ValidationException('You have already an offer!');
        }
    }

    public static function throwExceptionIfAuthoriziedUserInvalid(Project $project)
    {
        if ($project->user->id != auth()->id()) {
            throw new ValidationException('You are not the autherized user!');
        }
    }
}