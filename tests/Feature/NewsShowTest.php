<?php

namespace Tests\Feature;

use App\Livewire\NewsShow;
use App\Models\NewsArticle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

        Livewire::actingAs(User::factory()->create())
            ->test(NewsShow::class, ['newsArticle' => $article])
            ->assertSee(route('members'))
            ->assertDontSee(route('news'));
    }

    public function test_guest_is_redirected_from_members_only_article_to_members_area(): void
    {
        $article = NewsArticle::factory()->create([
            'is_active' => true,
            'is_members_only' => true,
            'published_at' => now()->subDay(),
        ]);

        Livewire::test(NewsShow::class, ['newsArticle' => $article])
            ->assertRedirect(route('members'));
    }

    public function test_it_shows_the_legacy_image_if_no_title_image_is_present(): void
    {
        config(['media-library.disk_name' => 'public']);
        Storage::fake('public');

        $article = NewsArticle::factory()->create([
            'is_active' => true,
            'published_at' => now()->subDay(),
        ]);

        $article->addMedia(UploadedFile::fake()->image('legacy-image.jpg'))->toMediaCollection('image');

        Livewire::test(NewsShow::class, ['newsArticle' => $article])
            ->assertSee($article->getFirstMediaUrl('image'));
    }

    public function test_it_shows_the_title_image_if_present(): void
    {
        config(['media-library.disk_name' => 'public']);
        Storage::fake('public');

        $article = NewsArticle::factory()->create([
            'is_active' => true,
            'published_at' => now()->subDay(),
        ]);

        $article->addMedia(UploadedFile::fake()->image('title-image.jpg'))->toMediaCollection('title_image');

        Livewire::test(NewsShow::class, ['newsArticle' => $article])
            ->assertSee($article->getFirstMediaUrl('title_image'));
    }
}
