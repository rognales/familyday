<?php

namespace Tests\Feature;

use App\Mail\PaymentConfirmation;
use App\Participant;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_redirect_to_login_page_when_unauthenticated()
    {
        $response = $this->get(route('admin_index'));

        $response->assertRedirect(route('login'));
    }

    public function test_it_should_reject_non_activated_admins_from_logging_in()
    {
        $admin = User::factory()->create();

        $response = $this->post(route('login'), [
            'username' => $admin->username,
            'password' => $admin->password,
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors();
    }

    public function test_it_should_able_to_delete_participant()
    {
        $admin = User::factory()->activated()->create();

        $participants = Participant::factory()->count(5)->create();
        $this->assertDatabaseCount(Participant::class, 5);

        $toBeDelete = $participants->first();

        $response = $this->actingAs($admin)->post(route('admin_user_delete'), ['pid' => $toBeDelete->id]);

        $response->assertSuccessful();
        $response->assertSessionDoesntHaveErrors();

        $this->assertCount(4, Participant::all());
        $this->assertSoftDeleted($toBeDelete);
        $this->assertEquals($admin->id, $toBeDelete->fresh()->deleted_by);
    }

    public function test_it_should_able_to_update_payment_and_send_email()
    {
        Mail::fake();

        $admin = User::factory()->activated()->create();
        $participant = Participant::factory()->nonMember()->create();

        $response = $this->actingAs($admin)->post(route('admin_payment_ajax_update'), [
            'pid' => $participant->id,
            'details' => 'this is payment details',
        ]);

        $response->assertSessionHasNoErrors();
        Mail::assertQueued(PaymentConfirmation::class);
    }

    public function test_it_should_not_change_price_when_updating_payment()
    {
        Mail::fake();

        $admin = User::factory()->activated()->create();
        $participant = Participant::factory()->nonMember()->createQuietly(['price' => 5000]);

        $this->assertEquals('50.00', $participant->price, 'Old price of non-member');

        $response = $this->actingAs($admin)->post(route('admin_payment_ajax_update'), [
            'pid' => $participant->id,
            'details' => 'this is payment details',
        ]);

        $this->assertEquals('50.00', $participant->price, 'Old price of non-member');

        $response->assertSessionHasNoErrors();
        Mail::assertQueued(PaymentConfirmation::class);
    }
}
