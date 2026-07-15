<?php

namespace Database\Factories;

use App\Models\MemberQuestionPollOption;
use App\Models\MemberQuestionPollVote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MemberQuestionPollVote>
 */
class MemberQuestionPollVoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $option = MemberQuestionPollOption::factory()->create();

        return [
            'member_question_id' => $option->member_question_id,
            'member_question_poll_option_id' => $option->id,
            'user_id' => User::factory(),
        ];
    }
}
