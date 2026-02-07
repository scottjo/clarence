<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $event = Event::factory()->create([
            'title' => 'Event with Image',
            'image' => 'events/test-image.jpg',
            'start_time' => now()->addDays(1),
            'is_active' => true,
        ]);

        Livewire::test(\App\Livewire\Home::class)
            ->assertSee('Event with Image')
            ->assertSee('events/test-image.jpg');
    }
}
