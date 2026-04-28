<?php

namespace Tests\Feature;

use App\Filament\Resources\Leagues\Pages\EditLeague;
use App\Models\League;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;
use Tests\TestCase;

class LeagueTableTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Enable league tables in settings for all tests
        Setting::factory()->create(['show_league_tables' => true]);
        Cache::forget('settings');
    }

    public function test_league_tables_hidden_when_feature_flag_disabled(): void
    {
        $settings = Setting::first();
        $settings->update(['show_league_tables' => false]);
        Cache::forget('settings');

        $response = $this->get(route('home'));
        $response->assertDontSee('Leagues');

        $response = $this->get(route('league-tables.index'));
        $response->assertSee('League Tables'); // Page title
    }

    public function test_league_tables_visible_in_nav_when_feature_flag_enabled(): void
    {
        League::factory()->create(['name' => 'Men\'s League', 'is_active' => true]);
        Cache::forget('active_leagues');

        $response = $this->get(route('home'));
        $response->assertSee('Leagues');
        $response->assertSee('Men\'s League');
    }

    public function test_league_tables_use_short_name_in_nav_when_available(): void
    {
        League::factory()->create([
            'name' => 'Very Long League Name That Does Not Fit',
            'short_name' => 'Short Name',
            'is_active' => true,
        ]);
        Cache::forget('active_leagues');

        $response = $this->get(route('home'));
        $response->assertSee('Short Name');
        $response->assertDontSee('Very Long League Name That Does Not Fit');
    }

    public function test_league_cache_refreshes_when_league_is_saved(): void
    {
        Cache::forget('active_leagues');

        $league = League::factory()->create([
            'name' => 'Initial League',
            'is_active' => true,
        ]);

        $response = $this->get(route('home'));
        $response->assertSee('Initial League');

        // Update the league name
        $league->update(['name' => 'Updated League']);

        $response = $this->get(route('home'));
        $response->assertSee('Updated League');
        $response->assertDontSee('Initial League');

        // Deleting should also refresh
        $league->delete();
        $response = $this->get(route('home'));
        $response->assertDontSee('Updated League');
    }

    public function test_league_cache_refreshes_when_setting_is_saved(): void
    {
        Cache::forget('settings');
        Cache::forget('active_leagues');

        $settings = Setting::first();
        $settings->update(['show_league_tables' => true]);

        League::factory()->create(['name' => 'Men\'s League', 'is_active' => true]);

        $response = $this->get(route('home'));
        $response->assertSee('Men\'s League');

        $settings->update(['show_league_tables' => false]);

        $response = $this->get(route('home'));
        $response->assertDontSee('Men\'s League');
    }

    public function test_can_view_league_tables_index(): void
    {
        $league1 = League::factory()->create(['name' => 'Men\'s League', 'is_active' => true]);
        $league1->standings()->create(['team_name' => 'Team A', 'season' => '2024', 'played' => 1, 'won' => 1, 'points' => 2]);
        $league1->standings()->create(['team_name' => 'Team A', 'season' => '2023', 'played' => 1, 'won' => 0, 'points' => 0]);

        $league2 = League::factory()->create(['name' => 'Ladies\' League', 'is_active' => true]);
        $league2->standings()->create(['team_name' => 'Team B', 'season' => '2024', 'played' => 1, 'won' => 1, 'points' => 2]);

        League::factory()->create(['name' => 'Inactive League', 'is_active' => false]);

        $response = $this->get(route('league-tables.index'));

        $response->assertStatus(200);
        $response->assertSee('Men\'s League');
        $response->assertSee('2024');
        $response->assertSee('Ladies\' League');
        $response->assertDontSee('Inactive League');
        $response->assertSee('2 seasons available');
    }

    public function test_can_view_individual_league_table(): void
    {
        $league = League::factory()->create(['name' => 'Men\'s League', 'is_active' => true, 'slug' => 'mens-league']);

        $league->standings()->create([
            'team_name' => 'CLARENCE BLUES',
            'season' => '2024',
            'played' => 2,
            'won' => 2,
            'points' => 26,
        ]);

        $league->standings()->create([
            'team_name' => 'CLARENCE BLUES',
            'season' => '2023',
            'played' => 2,
            'won' => 1,
            'points' => 13,
        ]);

        $response = $this->get(route('league-tables.show', ['league' => 'mens-league']));

        $response->assertStatus(200);
        $response->assertSee('Men\'s League');
        $response->assertSee('2024');
        $response->assertSee('CLARENCE BLUES');
        $response->assertSee('26');

        // Check for season selector
        $response->assertSee('Season:');
        $response->assertSee('2024');
        $response->assertSee('2023');

        // View another season
        $response = $this->get(route('league-tables.show', ['league' => 'mens-league', 'season' => '2023']));
        $response->assertStatus(200);
        $response->assertSee('2023');
        $response->assertSee('13');
    }

    public function test_can_view_league_message_below_table(): void
    {
        $league = League::factory()->create([
            'name' => 'Men\'s League',
            'is_active' => true,
            'slug' => 'mens-league',
            'message' => 'This is a test league message.',
        ]);

        $response = $this->get(route('league-tables.show', ['league' => 'mens-league']));

        $response->assertStatus(200);
        $response->assertSee('This is a test league message.');
    }

    public function test_can_view_standings_last_updated_time(): void
    {
        $league = League::factory()->create([
            'is_active' => true,
            'slug' => 'test-league',
        ]);

        $standing = $league->standings()->create([
            'team_name' => 'Team A',
            'season' => '2024',
            'played' => 1,
            'won' => 1,
            'points' => 2,
        ]);

        // Manually set updated_at to a known value
        $standing->updated_at = Carbon::parse('2026-04-28 10:00:00');
        $standing->save();

        $response = $this->get(route('league-tables.show', ['league' => 'test-league']));

        $response->assertStatus(200);
        $response->assertSee('Standings last updated: 28th Apr 2026 @ 10:00');
    }

    public function test_can_import_standings_in_filament(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        $league = League::factory()->create();

        $standingsText = "1 CLARENCE BLUES 2 2 0 0 5 0 7 0 217 179 38 26\n2 NAILSEA 2 1 0 1 6 0 6 0 197 215 -18 20";

        Livewire::actingAs($user)
            ->test(EditLeague::class, ['record' => $league->getRouteKey()])
            ->callAction('importStandings', [
                'season' => '2024',
                'standings' => $standingsText,
            ])
            ->assertHasNoActionErrors();

        $this->assertDatabaseCount('league_standings', 2);
        $this->assertDatabaseHas('league_standings', [
            'league_id' => $league->id,
            'season' => '2024',
            'team_name' => 'CLARENCE BLUES',
            'points' => 26,
            'points_difference' => 38,
        ]);
        $this->assertDatabaseHas('league_standings', [
            'league_id' => $league->id,
            'season' => '2024',
            'team_name' => 'NAILSEA',
            'points' => 20,
            'points_difference' => -18,
        ]);
    }
}
