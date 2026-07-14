<?php

namespace Database\Factories;

use App\Models\KnownMemberEmail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<KnownMemberEmail>
 */
class KnownMemberEmailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'name' => fake()->name(),
        ];
    }
}
