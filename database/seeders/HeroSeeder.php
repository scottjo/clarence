<?php

namespace Database\Seeders;

use App\Models\Hero;
use Illuminate\Database\Seeder;

class HeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Hero::create([
            'page_identifier' => 'home',
            'image' => 'https://images.unsplash.com/photo-1594132176008-012920f3404c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80',
            'title' => 'Welcome to Clarence Bowls Club',
            'subtitle' => 'Experience the joy of lawn bowls in a friendly and welcoming environment.',
            'intro_text' => "Join us for competition, fun, and community.\n\nWhether you're a seasoned pro or a complete beginner, we have something for everyone.",
            'title_color' => '#ffffff',
            'title_size' => 'text-5xl md:text-7xl',
            'subtitle_color' => '#ffffff',
            'subtitle_size' => 'text-xl md:text-2xl',
            'intro_color' => '#ffffff',
            'intro_size' => 'text-lg',
            'overlay_opacity' => 50,
        ]);

        Hero::create([
            'page_identifier' => 'about',
            'image' => 'https://images.unsplash.com/photo-1510563354640-27712558444c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80',
            'title' => 'About Our Club',
            'subtitle' => 'A century of bowling excellence in Clarence Park.',
            'intro_text' => 'Learn about our history, our values, and the people who make Clarence Bowls Club special.',
            'title_color' => '#ffffff',
            'title_size' => 'text-5xl md:text-7xl',
            'subtitle_color' => '#e2e8f0',
            'subtitle_size' => 'text-xl md:text-2xl',
            'intro_color' => '#f8fafc',
            'intro_size' => 'text-lg',
            'overlay_opacity' => 60,
        ]);
    }
}
