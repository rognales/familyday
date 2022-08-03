<?php

namespace Tests\Feature;

use App\Participant;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
