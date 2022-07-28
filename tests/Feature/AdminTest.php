<?php

namespace Tests\Feature;

use App\Participant;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

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
