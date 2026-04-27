<?php

namespace Tests\Feature;

use App\Livewire\NewsShow;
use App\Models\NewsArticle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class NewsShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_article_has_link_back_to_news(): void
    {
        $article = NewsArticle::factory()->create([
            'is_active' => true,
            'is_members_only' => false,
            'published_at' => now()->subDay(),
        ]);

        Livewire::test(NewsShow::class, ['newsArticle' => $article])
            ->assertSee(route('news'));
    }

    public function test_members_only_article_has_link_back_to_members_area(): void
    {
        $article = NewsArticle::factory()->create([
            'is_active' => true,
            'is_members_only' => true,
            'published_at' => now()->subDay(),
        ]);

        // Authenticate the session as required by NewsShow
        session(['members_authenticated' => true]);

        Livewire::test(NewsShow::class, ['newsArticle' => $article])
            ->assertSee(route('members'))
            ->assertDontSee(route('news'));
    }

    public function test_it_shows_the_legacy_image_if_no_title_image_is_present(): void
    {
        $article = NewsArticle::factory()->create([
            'is_active' => true,
            'published_at' => now()->subDay(),
        ]);

        $article->addMediaFromUrl('https://placehold.co/600x400.png')->toMediaCollection('image');

        Livewire::test(NewsShow::class, ['newsArticle' => $article])
            ->assertSee($article->getFirstMediaUrl('image'));
    }

    public function test_it_shows_the_title_image_if_present(): void
    {
        $article = NewsArticle::factory()->create([
            'is_active' => true,
            'published_at' => now()->subDay(),
        ]);

        $article->addMediaFromUrl('https://placehold.co/600x400.png')->toMediaCollection('title_image');

        Livewire::test(NewsShow::class, ['newsArticle' => $article])
            ->assertSee($article->getFirstMediaUrl('title_image'));
    }
}
