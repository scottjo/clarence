<?php

namespace Tests\Feature;

use App\Livewire\NewsShow;
use App\Models\NewsArticle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
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

        $article = NewsArticle::factory()->create([
            'is_active' => true,
            'published_at' => now()->subDay(),
        ]);

        $file1 = UploadedFile::fake()->create('test1.pdf', 100);
        $file2 = UploadedFile::fake()->create('test2.docx', 100);

        $article->addMedia($file1)->toMediaCollection('attachments');
        $article->addMedia($file2)->toMediaCollection('attachments');

        Livewire::test(NewsShow::class, ['newsArticle' => $article])
            ->assertSee('Attachments')
            ->assertSee('test1.pdf')
            ->assertSee('test2.docx')
            ->assertSee($article->getMedia('attachments')[0]->getUrl())
            ->assertSee($article->getMedia('attachments')[1]->getUrl());
    }
}
