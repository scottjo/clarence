<?php

namespace Tests\Feature;

use App\Models\Fixture;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FixtureShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_displays_fixture_details(): void
    {
        $fixture = Fixture::factory()->create([
            'opponent' => 'Test Bowls Club',
            'venue' => 'Home',
            'competition' => 'Test League',
            'notes' => 'Some test notes',
        ]);

        $response = $this->get(route('fixtures.show', $fixture));

        $response->assertStatus(200);
        $response->assertSee('Test Bowls Club');
        $response->assertSee('Home');
        $response->assertSee('Test League');
        $response->assertSee('Some test notes');
    }

    public function test_fixtures_list_links_to_details(): void
    {
        $fixture = Fixture::factory()->create([
            'opponent' => 'Linkable Opponent',
            'date' => now()->addDay(),
            'type' => \App\Enums\FixtureType::Men,
        ]);

        $response = $this->get(route('fixtures', ['type' => \App\Enums\FixtureType::Men->value]));

        $response->assertStatus(200);
        $response->assertSee(route('fixtures.show', $fixture));
    }
}
