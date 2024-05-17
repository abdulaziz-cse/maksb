<?php

namespace Database\Factories\V2\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\V2\Settings\PredefinedValue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    public const PASSWORD = '12345678901';

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'phone' => $this->faker->phoneNumber(),
            'type_id' => PredefinedValue::factory()->create()->id,
            'about' =>  $this->faker->text,
            'purchase_purpose' => $this->faker->text,
            'budget' => $this->faker->text(2),
            'favorite_value' => $this->faker->text(1),
            'profession' => $this->faker->text(1),
            'owner_of' => $this->faker->text(1),
            'portfolio' => $this->faker->url(),
            'website' => $this->faker->url(),
            'password' =>  Hash::make(self::PASSWORD),
            'remember_token' => $this->faker->text(1),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}