<?php

namespace Database\Factories;

use App\Models\MemberQuestion;
use App\Models\MemberQuestionPollOption;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MemberQuestionPollOption>
 */
class MemberQuestionPollOptionFactory extends Factory
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
            'label' => fake()->words(3, true),
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}
