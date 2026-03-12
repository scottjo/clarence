<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventOverlayTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_list_does_not_display_overlay_label(): void
    {
        $event = Event::factory()->create([
            'overlay_label' => 'STIKY LABEL',
            'is_active' => true,
            'start_time' => now()->addDay(),
        ]);

        $response = $this->get(route('events'));

        $response->assertStatus(200);
        $response->assertDontSee('STIKY LABEL');
    }

    public function test_home_page_displays_overlay_label(): void
    {
        $event = Event::factory()->create([
            'overlay_label' => 'STIKY LABEL',
            'is_active' => true,
            'start_time' => now()->addDay(),
        ]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('STIKY LABEL');
    }

    public function test_event_list_displays_overlay_message(): void
    {
        $event = Event::factory()->create([
            'overlay_message' => 'FULL OVERLAY MESSAGE',
            'is_active' => true,
            'start_time' => now()->addDay(),
        ]);

        $response = $this->get(route('events'));

        $response->assertStatus(200);
        $response->assertSee('FULL OVERLAY MESSAGE');
    }

    public function test_event_details_displays_overlay_message(): void
    {
        $event = Event::factory()->create([
            'overlay_message' => 'This is a long sticky note message.',
            'is_active' => true,
        ]);

        $response = $this->get(route('events.show', $event));

        $response->assertStatus(200);
        $response->assertSee('This is a long sticky note message.');
    }

    public function test_overlay_is_not_displayed_when_not_active(): void
    {
        $event = Event::factory()->create([
            'overlay_label' => 'INACTIVE LABEL',
            'overlay_message' => 'INACTIVE MESSAGE',
            'overlay_active' => false,
            'is_active' => true,
            'start_time' => now()->addDay(),
        ]);

        // Check home page
        $this->get(route('home'))
            ->assertDontSee('INACTIVE LABEL');

        // Check events list
        $this->get(route('events'))
            ->assertDontSee('INACTIVE MESSAGE');

        // Check event details
        $this->get(route('events.show', $event))
            ->assertDontSee('INACTIVE MESSAGE');
    }
}
