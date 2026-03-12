<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class EventImageLossTest extends TestCase
{
    use RefreshDatabase;

    public function test_updating_event_does_not_lose_image(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $event = Event::factory()->create();

        // Add an image to the event
        $image = UploadedFile::fake()->image('test.jpg');
        $event->addMedia($image)->toMediaCollection('image');

        $this->assertTrue($event->fresh()->hasMedia('image'));
        $this->assertEquals(1, $event->fresh()->getMedia('image')->count());

        // Simulate Filament Edit Page
        // We use Livewire::test on the EditEvent page
        Livewire::test(\App\Filament\Resources\Events\Pages\EditEvent::class, [
            'record' => $event->getRouteKey(),
        ])
            ->set('data.overlay_label', 'POSTPONED')
            ->call('save');

        $event = $event->fresh();
        $this->assertEquals('POSTPONED', $event->overlay_label);

        // This is where it's failing according to the user
        $this->assertTrue($event->hasMedia('image'), 'The event image was lost after saving the form.');
    }
}
