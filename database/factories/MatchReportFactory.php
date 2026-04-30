<?php

namespace Database\Factories;

use App\Models\MatchReport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MatchReport>
 */
class MatchReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ourScore = $this->faker->numberBetween(0, 100);
        $oppScore = $this->faker->numberBetween(0, 100);
        $team = $this->faker->randomElement(['Clarence A', 'Clarence B', 'Clarence Women']);
        $opponent = $this->faker->company();

        return [
            'team' => $team,
            'opponent' => $opponent,
            'year' => $this->faker->year(),
            'title' => "{$team} {$ourScore}-{$oppScore} {$opponent}",
            'our_score' => $ourScore,
            'opponent_score' => $oppScore,
            'author' => $this->faker->name(),
            'description' => $this->faker->paragraphs(3, true),
            'rink_scores' => "Rink 1: 21-15\nRink 2: 18-22\nRink 3: 25-10",
            'is_published' => true,
        ];
    }
}
