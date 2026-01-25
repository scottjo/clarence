<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
use Illuminate\Support\Str;

class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence();
        $start = $this->faker->dateTimeBetween('now', '+6 months');

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph(),
            'start_time' => $start,
            'end_time' => \Illuminate\Support\Carbon::parse($start)->addHours(3),
            'location' => $this->faker->address(),
            'is_active' => true,
        ];
    }
}
