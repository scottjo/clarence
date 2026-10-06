<?php

namespace Database\Factories;

use App\Models\HealthSafetyPage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HealthSafetyPage>
 */
class HealthSafetyPageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'slug' => fake()->unique()->slug(),
            'subtitle' => null,
            'content' => null,
            'is_active' => true,
        ];
    }
}
