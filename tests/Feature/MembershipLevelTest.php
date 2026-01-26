<?php

use App\Models\MembershipLevel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MembershipLevelTest extends TestCase
{
    use RefreshDatabase;

    public function test_membership_page_displays_levels(): void
    {
        $level = MembershipLevel::create([
            'name' => 'Test Level',
            'cost' => 99.00,
            'benefits' => 'Test Benefits',
            'sort_order' => 1,
        ]);

        $response = $this->get(route('about.membership'));

        $response->assertStatus(200);
        $response->assertSee('Test Level');
        $response->assertSee('£99');
        $response->assertSee('Test Benefits');
    }

    public function test_membership_levels_are_ordered_by_sort_order(): void
    {
        MembershipLevel::create([
            'name' => 'Second',
            'cost' => 20,
            'benefits' => 'B',
            'sort_order' => 2,
        ]);

        MembershipLevel::create([
            'name' => 'First',
            'cost' => 10,
            'benefits' => 'A',
            'sort_order' => 1,
        ]);

        $response = $this->get(route('about.membership'));

        $response->assertStatus(200);
        $response->assertSeeInOrder(['First', 'Second']);
    }

    public function test_membership_grid_adjusts_columns_based_on_count(): void
    {
        // Test with 3 levels
        MembershipLevel::factory()->count(3)->create();
        $response = $this->get(route('about.membership'));
        $response->assertSee('md:grid-cols-3');
        $response->assertDontSee('lg:grid-cols-4');

        // Test with 4 levels
        MembershipLevel::factory()->count(1)->create(); // total 4
        $response = $this->get(route('about.membership'));
        $response->assertSee('lg:grid-cols-4');
        $response->assertSee('md:grid-cols-2');
    }
}
