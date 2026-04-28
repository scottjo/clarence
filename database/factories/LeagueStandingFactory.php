<?php

namespace Database\Factories;

use App\Models\League;
use App\Models\LeagueStanding;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LeagueStanding>
 */
class LeagueStandingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'league_id' => League::factory(),
            'season' => '2024',
            'team_name' => $this->faker->company(),
            'played' => 0,
            'won' => 0,
            'drawn' => 0,
            'lost' => 0,
            'rinks_won' => 0,
            'rinks_drawn' => 0,
            'rinks_lost' => 0,
            'not_complete' => 0,
            'points_for' => 0,
            'points_against' => 0,
            'points_difference' => 0,
            'points' => 0,
            'sort_order' => 0,
        ];
    }
}
