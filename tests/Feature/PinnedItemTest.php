<?php

namespace Tests\Feature;

use App\Models\NewsArticle;
use App\Models\PinnedItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class PinnedItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_shows_active_pinned_items(): void
    {
        $pinned = PinnedItem::factory()->create([
            'title' => 'Important Notice',
            'is_active' => true,
        ]);

        $inactive = PinnedItem::factory()->create([
            'title' => 'Old Notice',
            'is_active' => false,
        ]);

        $this->get(route('home'))
            ->assertStatus(200)
            ->assertSee('Important Notice')
            ->assertDontSee('Old Notice');
    }

    public function test_pinned_item_links_to_news_article(): void
    {
        $article = NewsArticle::factory()->create(['title' => 'Article Title', 'is_active' => true]);
        $pinned = PinnedItem::factory()->create([
            'title' => 'Pinned with Link',
            'news_article_id' => $article->id,
            'is_active' => true,
        ]);

        $image = UploadedFile::fake()->image('notice.jpg');
        $pinned->addMedia($image)->toMediaCollection('image');

        $this->get(route('home'))
            ->assertStatus(200)
            ->assertSee('Pinned with Link')
            ->assertSee(route('news.show', $article))
            // Check that the image is wrapped in a link to the article
            ->assertSee('href="'.route('news.show', $article).'" class="block"', false);
    }

    public function test_pinned_item_shows_image(): void
    {
        Storage::fake('public');
        $pinned = PinnedItem::factory()->create(['title' => 'Image Notice']);
        $image = UploadedFile::fake()->image('notice.jpg');
        $pinned->addMedia($image)->toMediaCollection('image');

        Livewire::test(\App\Livewire\Home::class)
            ->assertSee('Image Notice')
            ->assertSee($pinned->getFirstMediaUrl('image'));
    }

    public function test_pinned_item_shows_pdf_open_button(): void
    {
        Storage::fake('public');
        $pinned = PinnedItem::factory()->create(['title' => 'PDF Notice']);

        // Use a real PDF header to ensure correct mime detection if necessary,
        // though usually UploadedFile::fake() with mime type should work.
        // The issue might be how Spatie Media Library detects it from a fake file.
        $pdf = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');
        $pinned->addMedia($pdf)
            ->withAttributes(['mime_type' => 'application/pdf'])
            ->toMediaCollection('image');

        $media = $pinned->getFirstMedia('image');

        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee('PDF Notice');
        $response->assertSee('Open Notice');
        $response->assertSee($media->getUrl());
    }

    public function test_pinned_item_has_correct_position_classes(): void
    {
        $leftItem = PinnedItem::factory()->create([
            'title' => 'Left Notice',
            'position' => 'left',
            'is_active' => true,
        ]);

        $rightItem = PinnedItem::factory()->create([
            'title' => 'Right Notice',
            'position' => 'right',
            'is_active' => true,
        ]);

        $this->get(route('home'))
            ->assertStatus(200)
            ->assertSee('Left Notice')
            ->assertSee('left-4 md:left-8 top-24 md:top-32 -rotate-2')
            ->assertSee('Right Notice')
            ->assertSee('right-4 md:right-8 top-24 md:top-32 rotate-2');
    }
}
