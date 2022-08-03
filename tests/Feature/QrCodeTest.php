<?php

namespace Tests\Feature;

use App\Participant;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QrCodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_prompt_for_login()
    {
        $participant = Participant::factory()->create();

        $response = $this->get(route('attend', ['slug' => $participant->slug()]));

        $response->assertRedirect(route('login'));
    }

    public function test_it_should_prompt_warning_if_scanned_prior_to_event_day()
    {
        $participant = Participant::factory()->create();
        $admin = User::factory()->activated()->create();

        $response = $this->actingAs($admin)->get(route('attend', ['slug' => $participant->slug()]));

        $this->assertAuthenticated();
        $response->assertViewIs('registration.error');
        $response->assertSee('too soon');
    }

    public function test_it_should_prompt_missing_or_invalid()
    {
        $eventDay = Carbon::parse(config('familyday.eventday'));

        $admin = User::factory()->activated()->create();

        $this->travelTo($eventDay);

        $response = $this->actingAs($admin)->get(route('attend', ['slug' => 'this-is-random-slug']));

        $this->assertAuthenticated();
        $response->assertViewIs('registration.error');
        $response->assertSee('QR code not valid');
    }

    public function test_it_should_prompt_for_missing_payment()
    {
        $eventDay = Carbon::parse(config('familyday.eventday'));

        $participant = Participant::factory()->create();
        $admin = User::factory()->activated()->create();

        $this->travelTo($eventDay);

        $response = $this->actingAs($admin)->get(route('attend', ['slug' => $participant->slug()]));

        $this->assertAuthenticated();
        $response->assertViewIs('registration.error');
        $response->assertSee('No payment info has been captured');
    }

    public function test_it_should_mark_as_attended_on_event_day()
    {
        $eventDay = Carbon::parse(config('familyday.eventday'));

        $participant = Participant::factory()->markAsPaid()->create();
        $admin = User::factory()->activated()->create();

        $this->travelTo($eventDay);

        $response = $this->actingAs($admin)->get(route('attend', ['slug' => $participant->slug()]));

        $this->assertAuthenticated();
        $response->assertViewIs('registration.show');
        $response->assertSee($participant->name);

        $participant->refresh();

        $this->assertEquals(1, $participant->attend);
        $this->assertTrue($participant->attendee->is($admin));
    }

    public function test_it_should_prompt_for_duplicate_if_already_attended()
    {
        $eventDay = Carbon::parse(config('familyday.eventday'));

        $participant = Participant::factory()->markAsPaid()->markAsAttended()->create();
        $admin = User::factory()->activated()->create();

        $this->travelTo($eventDay);

        $response = $this->actingAs($admin)->get(route('attend', ['slug' => $participant->slug()]));

        $this->assertAuthenticated();
        $response->assertViewIs('registration.error');
        $response->assertSee('QR code already scanned');
    }
}
