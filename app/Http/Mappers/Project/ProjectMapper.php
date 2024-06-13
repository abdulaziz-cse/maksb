<?php

namespace App\Http\Mappers\Project;

use App\Models\V2\User\User;

class ProjectMapper
{
    public function toSaveAcceptedProject(?int $statusId, User $buyer): array
    {
        return [
            'status_id' => $statusId,
            'buyer_id' => $buyer->id,
        ];
    }
}
