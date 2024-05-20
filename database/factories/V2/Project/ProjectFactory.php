<?php

namespace Database\Factories\V2\Project;

use App\Models\User;
use App\Models\V2\Project;
use App\Models\V2\Settings\PredefinedValue;
use App\Models\V2\Settings\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
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
            'user_id' => User::factory()->create()->id,
            'type_id' => PredefinedValue::factory()->create()->id,
            'website' => $this->faker->url(),
            'establishment_date' => $this->faker->date(),
            'country_id' => Region::factory()->create()->id,
            'other_platform' => $this->faker->name(),
            'currency_id' => 1,
            'category_id' => 1,
            'yearly' => $this->faker->randomDigit(),
            'other_assets' => $this->faker->name(),
            'is_supported' => $this->faker->boolean() ? 1 : 0,
            'support' => $this->faker->name(),
            'email_subscribers' => $this->faker->randomDigit(),
            'video_url' => $this->faker->url(),
            'price' => $this->faker->randomNumber(),
            'package_id' => 1,
            'description' => $this->faker->text(5),
            'short_description' => $this->faker->text(1),
        ];
    }
}