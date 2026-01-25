<?php

namespace Tests\Feature;

use App\Enums\FixtureType;
use App\Livewire\ResultsList;
use App\Models\Fixture;
use App\Models\Result;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ResultsTypeFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_shows_all_results_by_default(): void
    {
        $countyFixture = Fixture::factory()->create([
            'type' => FixtureType::CountyLeague,
            'opponent' => 'County Opponent',
        ]);
        Result::factory()->create(['fixture_id' => $countyFixture->id]);

        $ladiesFixture = Fixture::factory()->create([
            'type' => FixtureType::LadiesLeague,
            'opponent' => 'Ladies Opponent',
        ]);
        Result::factory()->create(['fixture_id' => $ladiesFixture->id]);

        Livewire::test(ResultsList::class)
            ->assertSee('County Opponent')
            ->assertSee('Ladies Opponent')
            ->assertSee('All Results');
    }

    public function test_it_filters_results_by_type(): void
    {
        $countyFixture = Fixture::factory()->create([
            'type' => FixtureType::CountyLeague,
            'opponent' => 'County Opponent',
        ]);
        Result::factory()->create(['fixture_id' => $countyFixture->id]);

        $ladiesFixture = Fixture::factory()->create([
            'type' => FixtureType::LadiesLeague,
            'opponent' => 'Ladies Opponent',
        ]);
        Result::factory()->create(['fixture_id' => $ladiesFixture->id]);

        Livewire::withQueryParams(['type' => FixtureType::LadiesLeague->value])
            ->test(ResultsList::class)
            ->assertSee('Ladies Opponent')
            ->assertDontSee('County Opponent')
            ->assertSee('Ladies League Results');
    }

    public function test_it_paginates_results(): void
    {
        $fixtures = Fixture::factory(15)->create([
            'type' => FixtureType::CountyLeague,
        ]);
        foreach ($fixtures as $fixture) {
            Result::factory()->create(['fixture_id' => $fixture->id]);
        }

        Livewire::test(ResultsList::class, ['perPage' => 10])
            ->assertSee('Results per page:')
            ->assertViewHas('results', function ($results) {
                return $results->count() === 10;
            })
            ->set('perPage', 5)
            ->assertViewHas('results', function ($results) {
                return $results->count() === 5;
            });
    }

    public function test_it_hides_per_page_dropdown_when_no_results(): void
    {
        Livewire::test(ResultsList::class)
            ->assertDontSee('Results per page:');
    }
}
