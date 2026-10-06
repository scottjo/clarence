<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Filament\Resources\HealthSafetyPages\Pages\CreateHealthSafetyPage;
use App\Filament\Resources\HealthSafetyPages\Pages\EditHealthSafetyPage;
use App\Models\HealthSafetyPage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class HealthSafetyPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu_and_index_link_to_active_pages_only(): void
    {
        $page = HealthSafetyPage::factory()->create(['title' => 'Safety policy']);
        HealthSafetyPage::factory()->create(['title' => 'Hidden policy', 'is_active' => false]);

        $this->get(route('about.health-safety'))->assertOk()
            ->assertSee('Club Health &amp; Safety', false)
            ->assertSee('Safety policy')->assertDontSee('Hidden policy')
            ->assertSee(route('about.health-safety.show', $page->slug));
        $this->get(route('about'))->assertSee(route('about.health-safety'));
    }

    public function test_empty_index_and_minimal_page_are_available(): void
    {
        $this->get(route('about.health-safety'))->assertOk()->assertSee('pages will appear here');
        $page = HealthSafetyPage::factory()->create();
        $this->get(route('about.health-safety.show', $page->slug))->assertOk()
            ->assertSee($page->title)->assertSee($page->created_at->format('j F Y, H:i'))
            ->assertDontSee('id="attachments-heading"', false);
    }

    public function test_inactive_and_missing_pages_return_not_found(): void
    {
        $page = HealthSafetyPage::factory()->create(['is_active' => false]);
        $this->get(route('about.health-safety.show', $page->slug))->assertNotFound();
        $this->get(route('about.health-safety.show', 'missing'))->assertNotFound();
    }

    public function test_page_displays_image_subtitle_safe_text_and_multiple_attachments(): void
    {
        Storage::fake('public');
        $page = HealthSafetyPage::factory()->create([
            'subtitle' => 'Keeping our members safe',
            'content' => '<p>Read the policy.</p><script>alert(1)</script>',
        ]);
        $image = $page->addMedia(UploadedFile::fake()->image('safety.jpg'))->toMediaCollection('title_image');
        $pdf = $page->addMedia(UploadedFile::fake()->create('policy.pdf', 10, 'application/pdf'))->toMediaCollection('attachments');
        $document = $page->addMedia(UploadedFile::fake()->create('checklist.docx', 10))->toMediaCollection('attachments');
        $other = $page->addMedia(UploadedFile::fake()->create('notes.txt', 10, 'text/plain'))->toMediaCollection('attachments');

        $this->get(route('about.health-safety.show', $page->slug))->assertOk()
            ->assertSee('Keeping our members safe')->assertSee('Read the policy.')
            ->assertDontSee('<script>alert(1)</script>', false)->assertSee($image->getUrl())
            ->assertSee('policy.pdf')->assertSee($pdf->getUrl())
            ->assertSee('checklist.docx')->assertSee($document->getUrl())
            ->assertSee('notes.txt')->assertSee($other->getUrl());
    }

    public function test_admin_can_create_edit_and_upload_page_files(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create(['is_admin' => true, 'roles' => [UserRole::SuperUser->value]]));

        Livewire::test(CreateHealthSafetyPage::class)
            ->fillForm([
                'title' => 'Club safety', 'slug' => 'club-safety', 'subtitle' => 'Our policy',
                'content' => '<p>Stay safe.</p>', 'is_active' => true,
                'title_image' => [UploadedFile::fake()->image('safety.jpg')],
                'attachments' => [UploadedFile::fake()->create('policy.pdf', 10, 'application/pdf'), UploadedFile::fake()->create('policy.docx', 10)],
            ])->call('create')->assertHasNoFormErrors()->assertRedirect();

        $page = HealthSafetyPage::query()->where('slug', 'club-safety')->firstOrFail();
        $this->assertNotNull($page->created_at);
        $this->assertTrue($page->hasMedia('title_image'));
        $this->assertCount(2, $page->getMedia('attachments'));
        Livewire::test(EditHealthSafetyPage::class, ['record' => $page->id])
            ->fillForm(['title' => 'Updated safety', 'subtitle' => null, 'content' => null])
            ->call('save')->assertHasNoFormErrors();
        $this->assertDatabaseHas(HealthSafetyPage::class, ['id' => $page->id, 'title' => 'Updated safety', 'subtitle' => null]);
        $this->assertSame('', strip_tags($page->fresh()->content));
        $this->assertCount(2, $page->fresh()->getMedia('attachments'));
    }

    public function test_admin_can_create_a_page_with_only_a_title_and_slug(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true, 'roles' => [UserRole::SuperUser->value]]));
        Livewire::test(CreateHealthSafetyPage::class)
            ->fillForm(['title' => 'Basic policy', 'slug' => 'basic-policy'])
            ->call('create')->assertHasNoFormErrors()->assertRedirect();
        $this->assertDatabaseHas(HealthSafetyPage::class, ['title' => 'Basic policy', 'subtitle' => null, 'is_active' => true]);
    }

    public function test_title_and_unique_slug_are_required(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true, 'roles' => [UserRole::SuperUser->value]]));
        Livewire::test(CreateHealthSafetyPage::class)->fillForm(['title' => '', 'slug' => ''])
            ->call('create')->assertHasFormErrors(['title' => 'required', 'slug' => 'required']);
        HealthSafetyPage::factory()->create(['slug' => 'existing']);
        Livewire::test(CreateHealthSafetyPage::class)->fillForm(['title' => 'Duplicate', 'slug' => 'existing'])
            ->call('create')->assertHasFormErrors(['slug' => 'unique']);
    }

    public function test_non_maintainers_cannot_manage_pages(): void
    {
        $user = User::factory()->create(['is_admin' => false, 'roles' => []]);
        $this->actingAs($user);
        $this->assertFalse($user->can('create', HealthSafetyPage::class));
        $this->assertFalse($user->can('viewAny', HealthSafetyPage::class));
    }
}
