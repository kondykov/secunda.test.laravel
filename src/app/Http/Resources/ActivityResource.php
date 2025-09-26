<?php

namespace App\Http\Resources;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Activity */
class ActivityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $includeChildren = $request->get('include_children', false);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent_id' => $this->parent()->first()?->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'children' => $this->when($includeChildren && $this->is_category,
                ActivityResource::collection($this->children)
            ),

            'parent' => new ActivityResource($this->whenLoaded('parent')),
        ];
    }
}
