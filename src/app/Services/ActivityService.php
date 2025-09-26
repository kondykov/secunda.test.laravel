<?php

namespace App\Services;

use App\Interfaces\ActivityServiceInterface;
use App\Models\Activity;
use App\Models\OrganizationActivity;

class ActivityService implements ActivityServiceInterface
{

    function getOrganizations(Activity $activity): array
    {
        $result = OrganizationActivity::where('activity_id', $activity->id)->pluck('organization_id')->toArray();

        /** @var Activity $child */
        foreach ($activity->children as $child) {
            $tmp = OrganizationActivity::where('activity_id', $child->id)->pluck('organization_id')->toArray();
            $result = array_merge($result, $tmp);
        }

        return $result;
    }
}
