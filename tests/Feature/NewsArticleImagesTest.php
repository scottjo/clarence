<?php

namespace Tests\Feature;

use App\Models\NewsArticle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class NewsArticleImagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_news_article_shows_title_image_and_gallery(): void
    {
        Storage::fake('public');

        $article = NewsArticle::factory()->create([
            'is_active' => true,
            'published_at' => now()->subDay(),
        ]);

        $titleImage = UploadedFile::fake()->image('title.jpg');
        $galleryImage1 = UploadedFile::fake()->image('gallery1.jpg');
        $galleryImage2 = UploadedFile::fake()->image('gallery2.jpg');

        $article->addMedia($titleImage)->toMediaCollection('title_image');
        $gallery1 = $article->addMedia($galleryImage1)->toMediaCollection('gallery');
        $gallery2 = $article->addMedia($galleryImage2)->toMediaCollection('gallery');

        Livewire::test('news-show', ['newsArticle' => $article])
            ->assertStatus(200)
            ->assertSee('title.jpg')
            ->assertSee('Gallery')
            ->assertSee($gallery1->getUrl('thumb'))
            ->assertSee($gallery2->getUrl('thumb'))
            ->assertSee($gallery1->getUrl('large'))
            ->assertSee($gallery2->getUrl('large'));
    }

    public function test_news_article_handles_fallback_image(): void
    {
        Storage::fake('public');

        $article = NewsArticle::factory()->create([
            'is_active' => true,
            'published_at' => now()->subDay(),
        ]);

        $oldImage = UploadedFile::fake()->image('old-image.jpg');
        $article->addMedia($oldImage)->toMediaCollection('image');

        // Test NewsShow view
        Livewire::test('news-show', ['newsArticle' => $article])
            ->assertStatus(200)
            ->assertSee($article->getFirstMediaUrl('image'));

        // Test NewsList view
        Livewire::test('news-list')
            ->assertStatus(200)
            ->assertSee($article->getFirstMediaUrl('image'));
    }
}
