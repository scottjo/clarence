<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\NewsArticle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_results_page_is_accessible(): void
    {
        $this->get(route('search'))
            ->assertStatus(200);
    }

    public function test_can_search_for_news_articles(): void
    {
        $article = NewsArticle::factory()->create([
            'title' => 'Important Bowls News',
            'content' => 'The season is starting soon!',
            'is_active' => true,
        ]);

        $otherArticle = NewsArticle::factory()->create([
            'title' => 'Other News',
            'is_active' => true,
        ]);

        Livewire::test(\App\Livewire\SearchResults::class, ['search' => 'Bowls'])
            ->assertSee('Important Bowls News')
            ->assertDontSee('Other News');
    }

    public function test_can_search_for_events(): void
    {
        $event = Event::factory()->create([
            'title' => 'Summer Tournament',
            'description' => 'A big tournament for everyone.',
            'is_active' => true,
            'start_time' => now()->addDays(1),
        ]);

        $otherEvent = Event::factory()->create([
            'title' => 'Winter Meeting',
            'is_active' => true,
            'start_time' => now()->addDays(2),
        ]);

        Livewire::test(\App\Livewire\SearchResults::class, ['search' => 'Tournament'])
            ->assertSee('Summer Tournament')
            ->assertDontSee('Winter Meeting');
    }

    public function test_can_search_for_officers(): void
    {
        $classification = \App\Models\OfficerClassification::factory()->create([
            'name' => 'Main Committee',
            'bg_color' => '#ff0000',
        ]);

        \App\Models\Officer::factory()->create([
            'name' => 'John Doe',
            'role' => \App\Enums\OfficerRole::President,
            'is_active' => true,
            'classification_id' => $classification->id,
        ]);

        \App\Models\Officer::factory()->create([
            'name' => 'Jane Smith',
            'role' => \App\Enums\OfficerRole::ClubSecretary,
            'is_active' => true,
        ]);

        Livewire::test(\App\Livewire\SearchResults::class, ['search' => 'John'])
            ->assertSee('John Doe')
            ->assertDontSee('Jane Smith');

        $this->get(route('about.officers'))
            ->assertStatus(200)
            ->assertSee('John Doe')
            ->assertSee('Main Committee')
            ->assertSee('#ff0000')
            ->assertDontSee('uppercase tracking-wider px-2 py-1 rounded-full border');
    }

    public function test_officers_are_grouped_by_classification_sort_order(): void
    {
        $classification2 = \App\Models\OfficerClassification::factory()->create([
            'name' => 'Second Committee',
            'sort_order' => 2,
        ]);

        $classification1 = \App\Models\OfficerClassification::factory()->create([
            'name' => 'First Committee',
            'sort_order' => 1,
        ]);

        \App\Models\Officer::factory()->create([
            'name' => 'Officer One',
            'role' => \App\Enums\OfficerRole::President,
            'classification_id' => $classification1->id,
            'is_active' => true,
        ]);

        \App\Models\Officer::factory()->create([
            'name' => 'Officer Two',
            'role' => \App\Enums\OfficerRole::ClubSecretary,
            'classification_id' => $classification2->id,
            'is_active' => true,
        ]);

        $response = $this->get(route('about.officers'));

        $response->assertStatus(200);

        // Verify that First Committee appears before Second Committee in the HTML
        $content = $response->getContent();
        $firstPos = strpos($content, 'First Committee');
        $secondPos = strpos($content, 'Second Committee');

        $this->assertNotFalse($firstPos);
        $this->assertNotFalse($secondPos);
        $this->assertTrue($firstPos < $secondPos, 'First Committee should appear before Second Committee');
    }

    public function test_can_search_for_fixtures(): void
    {
        \App\Models\Fixture::factory()->create([
            'opponent' => 'Weston Bowls Club',
            'venue' => 'Home',
        ]);

        \App\Models\Fixture::factory()->create([
            'opponent' => 'Bristol Club',
            'venue' => 'Away',
        ]);

        Livewire::test(\App\Livewire\SearchResults::class, ['search' => 'Weston'])
            ->assertSee('Weston Bowls Club')
            ->assertDontSee('Bristol Club');
    }

    public function test_can_search_for_results(): void
    {
        $fixture = \App\Models\Fixture::factory()->create(['opponent' => 'Bath Club']);
        \App\Models\Result::factory()->create([
            'fixture_id' => $fixture->id,
            'summary' => 'A very close match with Bath.',
        ]);

        $otherFixture = \App\Models\Fixture::factory()->create(['opponent' => 'Wells Club']);
        \App\Models\Result::factory()->create([
            'fixture_id' => $otherFixture->id,
            'summary' => 'An easy win against Wells.',
        ]);

        Livewire::test(\App\Livewire\SearchResults::class, ['search' => 'close match'])
            ->assertSee('Bath Club')
            ->assertSee('A very close match with Bath.')
            ->assertDontSee('Wells Club');
    }

    public function test_search_header_redirects_to_search_page(): void
    {
        $this->get(route('home'))
            ->assertStatus(200)
            ->assertSee('Search news, events...');

        $this->get(route('search', ['q' => 'Test Query']))
            ->assertStatus(200)
            ->assertSee('Test Query');
    }
}
