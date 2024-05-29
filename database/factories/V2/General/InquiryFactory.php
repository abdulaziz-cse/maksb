<?php

namespace Database\Factories\V2\Settings;

use App\Models\V2\General\Inquiry;
use App\Models\V2\Settings\PredefinedValue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inquiry>
 */
class InquiryFactory extends Factory
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
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'message' => $this->faker->text,
            'status_id' => PredefinedValue::factory()->create()->id,
        ];
    }
}