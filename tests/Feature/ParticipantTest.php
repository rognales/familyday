<?php

namespace Tests\Feature;

use App\Participant;
use App\Staff;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipantTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_can_bypass_hq_requirement_if_created_by_admin()
    {
        /* var User $admin */
        $admin = User::factory()->create();

        $single = Participant::factory()->make();

        $response = $this->actingAs($admin)->post(route('registration_create'), $single->toArray());

        $response->assertSessionDoesntHaveErrors();
        $this->assertDatabaseCount(Participant::class, 1);
    }

    public function test_it_can_create_single_participant()
    {
        // $this->markTestIncomplete();

        Staff::factory()->create(['staff_id' => 'TM12345']);

        $this->assertDatabaseHas(Staff::class, ['staff_id' => 'TM12345']);

        $response = $this->post(route('registration_create'), [
            'name' => 'zaiman',
            'email' => 'rognales@gmail.com',
            'is_vege' => false,
            'staff_id' => 'TM12345',
        ]);

        $response->assertSessionDoesntHaveErrors();
        $this->assertDatabaseCount(Participant::class, 1);
        // $response->assertRedirect(route('registration_show', $single));
    }

    public function test_it_can_validate_record()
    {
        $response = $this->post(route('registration_create'), [
            'name' => 'zaiman',
            'staff_id' => 'TM12345',
        ]);

        $response->assertSessionHasErrors();
        $this->assertDatabaseCount(Participant::class, 0);
    }
}
