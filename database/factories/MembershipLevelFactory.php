<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MembershipLevel>
 */
class MembershipLevelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'cost' => $this->faker->randomFloat(2, 10, 100),
            'benefits' => $this->faker->sentence(),
            'sort_order' => 0,
        ];
    }
}
