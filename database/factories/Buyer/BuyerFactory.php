<?php

namespace Database\Factories\Buyer;

use App\Models\Buyer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Buyer>
 */
class BuyerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'offer' => $this->faker->text,
            'message' => $this->faker->text,
            'law' => $this->faker->text,
            'nda' => $this->faker->boolean() ? 1 : 0,
            'consultant_type' => 1,
            'status_id' => 1,
            'project_id' => 1,
        ];
    }
}
