<?php

namespace App\Validators\Project;

use App\Enums\Project\ProjectStatus;
use App\Exceptions\ValidationException;
use App\Models\V2\Project;

class ProjectValidator
{
    public static function throwExceptionIfProjectHasOffers(Project $project)
    {
        if ($project->offers()->get()->isNotEmpty()) {
            throw new ValidationException('The Project Has an offers , you can not delete it now.');
        }
    }

    public static function throwExceptionIfProjectAlreadyAccepted(Project $project)
    {
        if ($project?->status?->slug == ProjectStatus::ACCEPTED->value) {
            throw new ValidationException('The project was no longer available: ' . $project?->status?->name);
        }
    }
}
