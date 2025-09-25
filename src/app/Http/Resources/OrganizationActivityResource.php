<?php

namespace App\Http\Resources;

use App\Models\OrganizationActivity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin OrganizationActivity */
class OrganizationActivityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'organization_id' => $this->organization_id,
            'activity_id' => $this->activity_id,

            'organization' => new OrganizationResource($this->whenLoaded('organization')),
            'activity' => new ActivityResource($this->whenLoaded('activity')),
        ];
    }
}
