<?php

namespace Tests\Feature;

use App\Mail\Enquiry;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Livewire\Livewire;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $settings = Setting::factory()->create();
        View::share('settings', $settings);
    }

    public function test_contact_form_submits_successfully(): void
    {
        Mail::fake();

        Livewire::test('contact')
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->set('phoneNumber', '0123456789')
            ->set('subject', 'Test Subject')
            ->set('message', 'This is a test message that is long enough.')
            ->call('submit')
            ->assertSet('success', true)
            ->assertHasNoErrors();

        Mail::assertSent(Enquiry::class, function ($mail) {
            return $mail->hasTo('jon_scott@me.com') &&
                   $mail->name === 'John Doe' &&
                   $mail->email === 'john@example.com';
        });
    }

    public function test_contact_form_validation_errors(): void
    {
        Livewire::test('contact')
            ->set('name', '')
            ->set('email', 'not-an-email')
            ->call('submit')
            ->assertHasErrors(['name' => 'required', 'email' => 'email']);
    }
}
