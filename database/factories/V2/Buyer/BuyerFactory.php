<?php

namespace Database\Factories\V2\Buyer;

use App\Models\User;
use App\Models\V2\Buyer\Buyer;
use App\Models\V2\Settings\PredefinedValue;
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
            'consultant_type_id' => PredefinedValue::factory()->create()->id,
            'status_id' => PredefinedValue::factory()->create()->id,
            'user_id' => User::factory()->create()->id,
        ];
    }
}