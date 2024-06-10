<?php

namespace App\Validators\Project;

use App\Exceptions\ValidationException;
use App\Models\V2\Project;

class ProjectValidator
{
    public static function throwExceptionIfProjectHasOffers(Project $project)
    {
        if ($project->buyers->isNotEmpty()) {
            throw new ValidationException('The Project Has an offers , you can not delete it now.');
        }
    }
}
