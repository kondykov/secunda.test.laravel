<?php

namespace App\Http\Resources;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Organization */
class OrganizationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phones' => $this->phones,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'building_id' => $this->building_id,

            'building' => new BuildingResource($this->whenLoaded('building')),
        ];
    }
}
