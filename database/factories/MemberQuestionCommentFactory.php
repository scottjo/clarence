<?php

namespace Database\Factories;

use App\Models\MemberAnswer;
use App\Models\MemberQuestionComment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MemberQuestionComment>
 */
class MemberQuestionCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_answer_id' => MemberAnswer::factory(),
            'user_id' => User::factory(),
            'body' => fake()->sentence(),
            'is_anonymous' => false,
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
