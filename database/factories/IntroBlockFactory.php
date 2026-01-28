<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IntroBlock>
 */
class IntroBlockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'page_identifier' => $this->faker->unique()->randomElement([
                'home', 'about', 'about.location', 'about.officers',
                'about.facilities', 'about.membership', 'about.history',
                'about.competition', 'fixtures', 'results', 'news',
                'events', 'contact',
            ]),
            'content' => $this->faker->paragraphs(2, true),
            'font_color' => '#111827',
            'left_image' => null,
            'right_image' => null,
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }
}
