<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class HomeEventsTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_shows_upcoming_events(): void
    {
        $event = Event::factory()->create([
            'title' => 'Upcoming Event',
            'start_time' => now()->addDays(1),
            'is_active' => true,
        ]);

        $this->get(route('home'))
            ->assertStatus(200)
            ->assertSee('Upcoming Event');
    }

    public function test_home_page_shows_event_image_if_present(): void
    {
        Storage::fake('public');

        $event = Event::factory()->create([
            'title' => 'Event with Image',
            'start_time' => now()->addDays(1),
            'is_active' => true,
        ]);

        $image = UploadedFile::fake()->image('test-image.jpg');
        $event->addMedia($image)->toMediaCollection('image');

        Livewire::test(\App\Livewire\Home::class)
            ->assertSee('Event with Image')
            ->assertSee($event->getFirstMediaUrl('image'));
    }
}
