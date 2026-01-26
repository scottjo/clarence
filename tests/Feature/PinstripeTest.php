<?php

namespace Tests\Feature;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PinstripeTest extends TestCase
{
    use RefreshDatabase;

    public function test_pinstripe_is_rendered_when_configured(): void
    {
        Setting::create([
            'club_name' => 'Test Club',
            'pinstripe_color' => '#ff0000',
            'pinstripe_width' => 'thick',
            'pinstripe_style' => 'single',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('background-color: #ff0000', false);
        $response->assertSee('height: 4px', false);
    }

    public function test_double_pinstripe_is_rendered(): void
    {
        Setting::create([
            'club_name' => 'Test Club',
            'pinstripe_color' => '#00ff00',
            'pinstripe_width' => 'thin',
            'pinstripe_style' => 'double',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('border-bottom: 1px solid #00ff00', false); // Header
        $response->assertSee('border-top: 1px solid #00ff00', false);    // Footer pinstripe div
    }

    public function test_footer_borders_use_pinstripe_color(): void
    {
        Setting::create([
            'club_name' => 'Test Club',
            'pinstripe_color' => '#123456',
            'pinstripe_width' => 'thin',
            'pinstripe_style' => 'single',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        // Footer top border
        $response->assertSee('border-top: 1px solid #123456', false);
        // Internal footer divider
        $response->assertSee('border-color: #123456', false);
    }

    public function test_pinstripe_is_not_rendered_when_color_is_missing(): void
    {
        Setting::create([
            'club_name' => 'Test Club',
            'pinstripe_color' => null,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('background-color: #ff0000');
    }
}
