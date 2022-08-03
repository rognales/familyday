<?php

namespace Tests\Feature;

use App\Mail\PaymentConfirmation;
use App\Mail\RegistrationConfirmation;
use App\Participant;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EmailerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_dispatch_registration_email()
    {
        Mail::fake();

        $admin = User::factory()->activated()->create();
        $participant = Participant::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin_resend_email'), [
            'pid' => $participant->id,
            'type' => 'registration',
        ]);

        $response->assertSuccessful();

        Mail::assertNotQueued(PaymentConfirmation::class);
        Mail::assertQueued(RegistrationConfirmation::class);
    }

    public function test_it_should_dispatch_payment_email()
    {
        Mail::fake();

        $admin = User::factory()->activated()->create();
        $participant = Participant::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin_resend_email'), [
            'pid' => $participant->id,
            'type' => 'payment',
        ]);

        $response->assertSuccessful();

        Mail::assertNotQueued(RegistrationConfirmation::class);
        Mail::assertQueued(PaymentConfirmation::class);
    }

    public function test_registration_email_content()
    {
        $participant = Participant::factory()->create();

        $mailable = new RegistrationConfirmation($participant);

        $mailable->assertSeeInHtml($participant->staff_id);
        $mailable->assertSeeInHtml($participant->total_price);
        $mailable->assertSeeInHtml('You may now proceed with online payment');
    }

    public function test_payment_email_content()
    {
        $participant = Participant::factory()->create();

        $mailable = new PaymentConfirmation($participant);

        $mailable->assertSeeInHtml($participant->staff_id);
        $mailable->assertSeeInHtml('Please bring this QR code for admission during the event');
    }
}
