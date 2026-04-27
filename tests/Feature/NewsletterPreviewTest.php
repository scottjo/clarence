<?php

namespace Tests\Feature;

use App\Livewire\MembersArea;
use App\Models\Newsletter;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class NewsletterPreviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_members_area_displays_newsletter_with_preview_placeholder(): void
    {
        Storage::fake('public');

        $newsletter = Newsletter::factory()->create([
            'title' => 'Test Newsletter',
            'issue_date' => '2026-04-01',
        ]);

        // Add a fake PDF
        $file = UploadedFile::fake()->create('newsletter.pdf', 100, 'application/pdf');
        $newsletter->addMedia($file)->toMediaCollection('newsletter_pdf');

        $settings = Setting::factory()->create([
            'members_password' => 'secret',
        ]);

        // Simulate middleware sharing
        config(['settings' => $settings]);
        view()->share('settings', $settings);

        Livewire::test(MembersArea::class)
            ->set('password', 'secret')
            ->call('login')
            ->assertSee('Test Newsletter')
            ->assertSee('April 2026')
            // Check for the presence of the blue background placeholder with newspaper icon
            ->assertSeeHtml('bg-blue-50 dark:bg-blue-900/20 rounded overflow-hidden shrink-0 border border-blue-100 dark:border-blue-800 flex items-center justify-center text-blue-600 dark:text-blue-400');
    }
}
