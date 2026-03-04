<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\UsefulContact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;
use Livewire\Livewire;
use Tests\TestCase;

class UsefulContactsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $settings = Setting::factory()->create();
        View::share('settings', $settings);
    }

    public function test_contact_page_shows_active_useful_contacts(): void
    {
        $activeContact = UsefulContact::factory()->create([
            'name' => 'Active Contact',
            'is_active' => true,
        ]);

        $inactiveContact = UsefulContact::factory()->create([
            'name' => 'Inactive Contact',
            'is_active' => false,
        ]);

        Livewire::test('contact')
            ->assertSee('Active Contact')
            ->assertDontSee('Inactive Contact');
    }

    public function test_contact_page_shows_useful_contacts_message(): void
    {
        $settings = Setting::factory()->create([
            'useful_contacts_message' => 'Test message for useful contacts.',
        ]);
        View::share('settings', $settings);

        UsefulContact::factory()->create(['is_active' => true]);

        Livewire::test('contact')
            ->assertSee('Test message for useful contacts.');
    }

    public function test_useful_contacts_are_ordered_by_sort_order(): void
    {
        UsefulContact::factory()->create(['name' => 'Contact B', 'sort_order' => 2]);
        UsefulContact::factory()->create(['name' => 'Contact A', 'sort_order' => 1]);

        Livewire::test('contact')
            ->assertSeeInOrder(['Contact A', 'Contact B']);
    }

    public function test_two_useful_contacts_are_centered(): void
    {
        UsefulContact::factory()->count(2)->create(['is_active' => true]);

        Livewire::test('contact')
            ->assertSee('lg:flex lg:justify-center')
            ->assertSee('lg:w-1/3 lg:max-w-md');
    }
}
