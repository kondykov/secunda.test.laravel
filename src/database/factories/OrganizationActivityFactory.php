<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\Organization;
use App\Models\OrganizationActivity;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrganizationActivityFactory extends Factory
{
    protected $model = OrganizationActivity::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'organization_id' => Organization::factory(),
            'activity_id' => Activity::factory(),
        ];
    }
}
