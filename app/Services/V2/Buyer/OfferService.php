<?php

namespace App\Services\V2\Buyer;

use App\Models\V2\Buyer\Buyer;

class OfferService
{
    public function updateStatus(array $requestData, Buyer $buyer): Buyer
    {
        $projectId = $requestData['project_id'];
        $isAccepted = $requestData['is_accepted'];

        $buyer->projects()->updateExistingPivot(
            $projectId,
            [
                'is_accepted' => $isAccepted,
            ]
        );

        return $buyer;
    }
}