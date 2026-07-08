<?php

namespace Database\Factories;

use App\Models\MemberQuestion;
use App\Models\MemberQuestionVote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MemberQuestionVote>
 */
class MemberQuestionVoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_question_id' => MemberQuestion::factory(),
            'user_id' => User::factory(),
            'value' => 1,
        ];
    }

    public function down(): static
    {
        return $this->state(fn (array $attributes): array => [
            'value' => -1,
        ]);
    }
}
