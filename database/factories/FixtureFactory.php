<?php

namespace Database\Factories;

use App\Enums\FixtureType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fixture>
 */
class FixtureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(FixtureType::cases()),
            'opponent' => $this->faker->company().' Bowls Club',
            'date' => $this->faker->dateTimeBetween('now', '+6 months'),
            'venue' => $this->faker->randomElement(['Home', 'Away']),
            'competition' => $this->faker->randomElement(['League', 'Friendly', 'Cup', 'County League', 'Over 55s League', 'Ladies League']),
            'notes' => $this->faker->sentence(),
        ];
    }
}
