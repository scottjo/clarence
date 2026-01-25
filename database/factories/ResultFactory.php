<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Result>
 */
class ResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fixture_id' => \App\Models\Fixture::factory(),
            'home_score' => $this->faker->numberBetween(10, 30),
            'away_score' => $this->faker->numberBetween(10, 30),
            'summary' => $this->faker->paragraph(),
        ];
    }
}
