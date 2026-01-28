<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hero>
 */
class HeroFactory extends Factory
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
            'image' => null,
            'title' => $this->faker->sentence(3),
            'subtitle' => $this->faker->sentence(5),
            'intro_text' => $this->faker->sentence(),
            'title_color' => '#ffffff',
            'title_size' => '3xl',
            'subtitle_color' => '#e5e7eb',
            'subtitle_size' => 'xl',
            'intro_color' => '#d1d5db',
            'intro_size' => 'lg',
            'font_family' => 'sans-serif',
            'overlay_opacity' => 50,
        ];
    }
}
