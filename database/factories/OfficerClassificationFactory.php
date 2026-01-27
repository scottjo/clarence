<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OfficerClassification>
 */
class OfficerClassificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'bg_color' => $this->faker->safeHexColor(),
            'text_color' => $this->faker->safeHexColor(),
            'bg_color_dark' => $this->faker->safeHexColor(),
            'text_color_dark' => $this->faker->safeHexColor(),
            'sort_order' => 0,
        ];
    }
}
