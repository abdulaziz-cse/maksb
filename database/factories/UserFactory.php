<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

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
            'type_id' => 1,
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

        // return [
        //     'name' => fake()->name(),
        //     'email' => fake()->unique()->safeEmail(),
        //     'email_verified_at' => now(),
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'remember_token' => Str::random(10),
        // ];
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
