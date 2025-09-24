<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\ActivityCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'activity_categories_id' => ActivityCategory::factory(),
        ];
    }
}
