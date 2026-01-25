<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        \App\Models\Fixture::factory(10)->create();
        \App\Models\Result::factory(5)->create();
        \App\Models\NewsArticle::factory(5)->create();
        \App\Models\Event::factory(5)->create();

        $this->call([
            SettingSeeder::class,
            HeroSeeder::class,
            IntroBlockSeeder::class,
        ]);
    }
}
