<?php

namespace Tests\Feature;

use App\Enums\FixtureType;
use App\Livewire\FixturesList;
use App\Models\Fixture;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FixturesPaginationTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_paginates_fixtures(): void
    {
        Fixture::factory(15)->create([
            'type' => FixtureType::Men,
            'date' => now()->addDays(1),
        ]);

        Livewire::test(FixturesList::class, ['perPage' => 10])
            ->assertSee('Fixtures per page:')
            ->assertViewHas('fixtures', function ($fixtures) {
                return $fixtures->count() === 10;
            })
            ->set('perPage', 5)
            ->assertViewHas('fixtures', function ($fixtures) {
                return $fixtures->count() === 5;
            });
    }

    public function test_it_hides_per_page_dropdown_when_no_fixtures(): void
    {
        Livewire::test(FixturesList::class)
            ->assertDontSee('Fixtures per page:');
    }

    public function test_it_only_shows_future_fixtures_with_pagination(): void
    {
        // Past fixture
        Fixture::factory()->create([
            'type' => FixtureType::Men,
            'date' => now()->subDay(),
            'opponent' => 'Past Opponent',
        ]);

        // Future fixture
        Fixture::factory()->create([
            'type' => FixtureType::Men,
            'date' => now()->addDay(),
            'opponent' => 'Future Opponent',
        ]);

        Livewire::test(FixturesList::class)
            ->assertSee('Future Opponent')
            ->assertDontSee('Past Opponent');
    }
}
