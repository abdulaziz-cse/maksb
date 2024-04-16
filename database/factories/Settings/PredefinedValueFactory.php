<?php

namespace Database\Factories\Settings;

use App\Models\Settings\PredefinedValue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PredefinedValue>
 */
class PredefinedValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
        ];
    }
}
