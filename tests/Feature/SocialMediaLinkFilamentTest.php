<?php

namespace Tests\Feature;

use App\Enums\SocialPlatform;
use App\Filament\Resources\SocialMediaLinks\Pages\CreateSocialMediaLink;
use App\Filament\Resources\SocialMediaLinks\Pages\ListSocialMediaLinks;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SocialMediaLinkFilamentTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_list_page(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(ListSocialMediaLinks::class)
            ->assertStatus(200);
    }

    public function test_can_create_social_media_link(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(CreateSocialMediaLink::class)
            ->fillForm([
                'platform' => SocialPlatform::Facebook->value,
                'url' => 'https://facebook.com',
                'icon' => SocialPlatform::Facebook->getIcon(),
                'sort_order' => 1,
                'is_active' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('social_media_links', [
            'platform' => SocialPlatform::Facebook->value,
            'icon' => SocialPlatform::Facebook->getIcon(),
        ]);
    }
}
