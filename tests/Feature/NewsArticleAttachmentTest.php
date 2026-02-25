<?php

namespace Tests\Feature;

use App\Livewire\NewsShow;
use App\Models\NewsArticle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class NewsArticleAttachmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_attachments_on_news_article_page()
    {
        Storage::fake('public');

        $file1 = 'attachments/test1.pdf';
        $file2 = 'attachments/test2.docx';
        Storage::disk('public')->put($file1, 'content');
        Storage::disk('public')->put($file2, 'content');

        $article = NewsArticle::factory()->create([
            'attachments' => [$file1, $file2],
            'is_active' => true,
            'published_at' => now()->subDay(),
        ]);

        Livewire::test(NewsShow::class, ['newsArticle' => $article])
            ->assertSee('Attachments')
            ->assertSee('test1.pdf')
            ->assertSee('test2.docx')
            ->assertSee(Storage::url($file1))
            ->assertSee(Storage::url($file2));
    }
}
