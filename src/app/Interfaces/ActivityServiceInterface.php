<?php

namespace App\Interfaces;

use App\Models\Activity;

interface ActivityServiceInterface
{
    function getOrganizations(Activity $activity): array;
}
