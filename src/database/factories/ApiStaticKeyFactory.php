<?php

namespace Database\Factories;

use App\Models\ApiStaticKey;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ApiStaticKeyFactory extends Factory
{
    protected $model = ApiStaticKey::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'key' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
