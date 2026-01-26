<?php

namespace Tests\Feature;

use App\Models\Facility;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FacilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_facilities_page_displays_facilities(): void
    {
        Facility::create([
            'title' => 'Test Facility',
            'description' => 'Test Description',
            'image_position' => 'left',
            'sort_order' => 1,
        ]);

        $response = $this->get(route('about.facilities'));

        $response->assertStatus(200);
        $response->assertSee('Test Facility');
        $response->assertSee('Test Description');
    }

    public function test_facilities_are_ordered_by_sort_order(): void
    {
        Facility::create([
            'title' => 'Second',
            'description' => 'Desc',
            'image_position' => 'left',
            'sort_order' => 2,
        ]);

        Facility::create([
            'title' => 'First',
            'description' => 'Desc',
            'image_position' => 'left',
            'sort_order' => 1,
        ]);

        $response = $this->get(route('about.facilities'));

        $response->assertStatus(200);
        $response->assertSeeInOrder(['First', 'Second']);
    }

    public function test_facilities_grid_layout_on_large_screens(): void
    {
        Facility::factory()->count(2)->create();

        $response = $this->get(route('about.facilities'));

        $response->assertSee('grid');
        $response->assertSee('lg:grid-cols-2');
    }
}
