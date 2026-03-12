<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventOverlayTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_list_displays_overlay_label(): void
    {
        $event = Event::factory()->create([
            'overlay_label' => 'STIKY LABEL',
            'is_active' => true,
            'start_time' => now()->addDay(),
        ]);

        $response = $this->get(route('events'));

        $response->assertStatus(200);
        $response->assertSee('STIKY LABEL');
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
}
