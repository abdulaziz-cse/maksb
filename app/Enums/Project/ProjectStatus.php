<?php

namespace App\Enums\Project;

enum ProjectStatus: string
{
    case OPEN = 'projectStatus-open';

    case ACCEPTED = 'projectStatus-accepted';

    case SOLD = 'projectStatus-sold';
}
