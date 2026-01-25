<?php

namespace Tests\Feature;

use App\Enums\FixtureType;
use App\Livewire\FixturesList;
use App\Models\Fixture;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FixturesTypeChangeTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_shows_men_fixtures_by_default(): void
    {
        Fixture::factory()->create([
            'type' => FixtureType::Men,
            'opponent' => 'Men Opponent',
            'date' => now()->addDay(),
        ]);

        Fixture::factory()->create([
            'type' => FixtureType::Women,
            'opponent' => 'Women Opponent',
            'date' => now()->addDay(),
        ]);

        Livewire::test(FixturesList::class)
            ->assertSee('Men Opponent')
            ->assertDontSee('Women Opponent');
    }

    public function test_it_shows_women_fixtures_when_type_is_provided(): void
    {
        Fixture::factory()->create([
            'type' => FixtureType::Men,
            'opponent' => 'Men Opponent',
            'date' => now()->addDay(),
        ]);

        Fixture::factory()->create([
            'type' => FixtureType::Women,
            'opponent' => 'Women Opponent',
            'date' => now()->addDay(),
        ]);

        Livewire::withQueryParams(['type' => FixtureType::Women->value])
            ->test(FixturesList::class)
            ->assertSee('Women Opponent')
            ->assertDontSee('Men Opponent');
    }
}
