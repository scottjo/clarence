<?php

namespace Database\Factories;

use App\Models\MemberQuestion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MemberQuestion>
 */
class MemberQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(6),
            'body' => fake()->paragraph(),
            'is_anonymous' => false,
            'is_locked' => false,
            'allow_member_answers' => false,
            'display_name' => fake()->name(),
        ];
    }

    public function anonymous(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_anonymous' => true,
            'display_name' => null,
        ]);
    }
}
