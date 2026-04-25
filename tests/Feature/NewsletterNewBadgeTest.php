<?php

namespace Tests\Feature;

use App\Livewire\MembersArea;
use App\Models\Newsletter;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class NewsletterNewBadgeTest extends TestCase
{
    use RefreshDatabase;

    public function test_is_recent_method_works(): void
    {
        $newNewsletter = Newsletter::factory()->create([
            'created_at' => now(),
        ]);

        $oldNewsletter = Newsletter::factory()->create([
            'created_at' => now()->subDays(15),
        ]);

        $this->assertTrue($newNewsletter->isRecent());
        $this->assertFalse($oldNewsletter->isRecent());
    }

    public function test_new_badge_is_rendered_for_recent_newsletters(): void
    {
        $newsletter = Newsletter::factory()->create([
            'title' => 'Recent Newsletter',
            'created_at' => now(),
        ]);

        $settings = Setting::factory()->create([
            'members_password' => 'secret',
        ]);

        // Simulate middleware sharing
        config(['settings' => $settings]);
        view()->share('settings', $settings);

        Livewire::test(MembersArea::class)
            ->set('password', 'secret')
            ->call('login')
            ->assertSee('Recent Newsletter')
            ->assertSeeHtml('x-show="!seenNewsletters.includes('.$newsletter->id.')"')
            ->assertSee('New');
    }

    public function test_new_badge_is_not_rendered_for_old_newsletters(): void
    {
        $newsletter = Newsletter::factory()->create([
            'title' => 'Old Newsletter',
            'created_at' => now()->subDays(15),
        ]);

        $settings = Setting::factory()->create([
            'members_password' => 'secret',
        ]);

        // Simulate middleware sharing
        config(['settings' => $settings]);
        view()->share('settings', $settings);

        Livewire::test(MembersArea::class)
            ->set('password', 'secret')
            ->call('login')
            ->assertSee('Old Newsletter')
            ->assertDontSeeHtml('<span x-show="!seenNewsletters.includes('.$newsletter->id.')"');
    }
}
