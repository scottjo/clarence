<?php

namespace Database\Factories;

use App\Enums\OfficerRole;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Officer>
 */
class OfficerFactory extends Factory
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
            'role' => $this->faker->randomElement(OfficerRole::cases()),
            'avatar' => null,
            'sort_order' => 0,
            'is_active' => true,
            'classification_id' => null,
        ];
    }

    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }
}
