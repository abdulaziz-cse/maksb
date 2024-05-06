<?php

namespace Database\Factories\V2\Settings;

use App\Models\V2\Settings\PredefinedValue;
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
