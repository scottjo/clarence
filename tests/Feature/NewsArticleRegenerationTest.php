<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Filament\Resources\NewsArticles\Pages\ListNewsArticles;
use App\Models\NewsArticle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Livewire\Livewire;
use Tests\TestCase;

class NewsArticleRegenerationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_regenerate_thumbnails_from_list_page(): void
    {
        $user = User::factory()->create([
            'is_admin' => true,
            'roles' => [UserRole::SuperUser->value],
        ]);

        // Create an article
        NewsArticle::factory()->create();

        // Mock Artisan call
        Artisan::shouldReceive('call')
            ->with('media-library:regenerate', \Mockery::any())
            ->andReturn(0);

        Livewire::actingAs($user)
            ->test(ListNewsArticles::class)
            ->callAction('regenerateThumbnails')
            ->assertHasNoActionErrors();
    }
}
