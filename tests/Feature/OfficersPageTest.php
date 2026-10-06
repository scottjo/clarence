<?php

namespace Tests\Feature;

use App\Enums\OfficerRole;
use App\Enums\UserRole;
use App\Filament\Resources\Officers\Pages\CreateOfficer;
use App\Models\Officer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class OfficersPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_an_officer_via_filament(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
            'roles' => [UserRole::SuperUser->value],
        ]);
        $this->actingAs($admin);

        Livewire::test(CreateOfficer::class)
            ->fillForm([
                'name' => 'New Officer',
                'biography' => 'A lifelong bowler and club volunteer.',
                'role' => OfficerRole::President,
                'sort_order' => 10,
                'is_active' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors()
            ->assertRedirect();

        $this->assertDatabaseHas(Officer::class, [
            'name' => 'New Officer',
            'biography' => 'A lifelong bowler and club volunteer.',
            'role' => OfficerRole::President->value,
            'sort_order' => 10,
        ]);
    }

    public function test_it_displays_active_officers_in_correct_order(): void
    {
        $officerB = Officer::create([
            'name' => 'Officer B',
            'role' => OfficerRole::VicePresident,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $officerA = Officer::create([
            'name' => 'Officer A',
            'role' => OfficerRole::President,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $inactiveOfficer = Officer::create([
            'name' => 'Inactive Officer',
            'role' => OfficerRole::ClubSecretary,
            'sort_order' => 0,
            'is_active' => false,
        ]);

        $response = $this->get(route('about.officers'));

        $response->assertStatus(200);
        $response->assertSeeInOrder(['Officer A', 'Officer B']);
        $response->assertDontSee('Inactive Officer');
    }

    public function test_it_displays_initials_when_no_avatar(): void
    {
        Officer::create([
            'name' => 'John Doe',
            'role' => OfficerRole::ClubSecretary,
            'is_active' => true,
        ]);

        $response = $this->get(route('about.officers'));

        $response->assertSee('JD');
    }

    public function test_officer_cards_open_biography_dialogs_with_their_details(): void
    {
        $officer = Officer::factory()->create([
            'name' => 'Jane Smith',
            'role' => OfficerRole::President,
            'biography' => "A club volunteer.\nEnjoys coaching beginners. <script>alert(1)</script>",
        ]);

        $response = $this->get(route('about.officers'));

        $response->assertOk()
            ->assertSee('Read biography of Jane Smith')
            ->assertSee('aria-controls="biography-'.$officer->id.'"', false)
            ->assertSee('x-on:click="$refs.biography.showModal()"', false)
            ->assertSee('<dialog', false)
            ->assertSee('Jane Smith')
            ->assertSee('President')
            ->assertSee('JS')
            ->assertSee($officer->biography)
            ->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_missing_biographies_have_a_fallback_and_inactive_biographies_are_hidden(): void
    {
        Officer::factory()->create(['biography' => null]);
        Officer::factory()->inactive()->create(['biography' => 'Private inactive biography.']);

        $this->get(route('about.officers'))
            ->assertOk()
            ->assertSee('Biography not yet available.')
            ->assertDontSee('Private inactive biography.');
    }
}
