<?php

namespace Tests\Feature;

use App\Dependant;
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

    public function test_it_should_return_landing_page()
    {
        $response = $this->get(route('index'));

        $response->assertViewIs('layouts.theme');
    }

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

    public function test_it_can_find_by_slug()
    {
        $participant = Participant::factory()->create();

        $response = $this->get(route('registration_show', ['slug' => $participant->slug()]));

        $response->assertSuccessful();
        $response->assertSee($participant->name);
        $response->assertSee($participant->staff_id);
    }

    public function test_it_should_return_404_for_modified_slug()
    {
        $participant = Participant::factory()->create();

        $response = $this->get(route('registration_show', ['slug' => $participant->slug().'zaiman']));

        $response->assertNotFound();
    }

    public function test_it_should_show_payment_instructions()
    {
        $participant = Participant::factory()->create();

        $response = $this->get(route('registration_show', ['slug' => $participant->slug()]));

        $response->assertSuccessful();
        $response->assertSee(config('familyday.banking.name'));
        $response->assertSee(config('familyday.banking.number'));
    }

    public function test_it_can_assign_correct_price_for_member()
    {
        $staff = Staff::factory()->member()->create();

        $response = $this->post(route('registration_create'), [
            'name' => 'zaiman',
            'staff_id' => $staff->staff_id,
            'email' => 'rognales@gmail.com',
            'is_vege' => '1',
            'dependant_relationship' => ['Spouse'],
            'dependant_name' => ['Waifu'],
            'dependant_age' => ['22'],
        ]);

        $response->assertSessionDoesntHaveErrors();
        $this->assertDatabaseCount(Participant::class, 1);
        $this->assertDatabaseCount(Dependant::class, 1);

        $participant = Participant::first();

        $this->assertEquals(15 + 15, $participant->total_price);
    }

    public function test_it_can_assign_correct_price_for_member_with_free_dependants()
    {
        $staff = Staff::factory()->member()->create();

        $response = $this->post(route('registration_create'), [
            'name' => 'zaiman',
            'staff_id' => $staff->staff_id,
            'email' => 'rognales@gmail.com',
            'is_vege' => '1',
            'dependant_relationship' => ['Spouse', 'Infant', 'OKU'],
            'dependant_name' => ['Waifu', 'Anakku', 'Anak Syurga'],
            'dependant_age' => ['22', '2', '14'],
        ]);

        $response->assertSessionDoesntHaveErrors();
        $this->assertDatabaseCount(Participant::class, 1);
        $this->assertDatabaseCount(Dependant::class, 3);

        $participant = Participant::first();

        $this->assertEquals(15 + 15 + 0 + 0, $participant->total_price);
    }

    public function test_it_can_assign_correct_price_for_member_with_paying_dependants()
    {
        $staff = Staff::factory()->member()->create();

        $response = $this->post(route('registration_create'), [
            'name' => 'zaiman',
            'staff_id' => $staff->staff_id,
            'email' => 'rognales@gmail.com',
            'is_vege' => '1',
            'dependant_relationship' => ['Spouse', 'Kids', 'Others'],
            'dependant_name' => ['Waifu', 'Anakku', 'Anak Jiran'],
            'dependant_age' => ['22', '4', '14'],
        ]);

        $response->assertSessionDoesntHaveErrors();
        $this->assertDatabaseCount(Participant::class, 1);
        $this->assertDatabaseCount(Dependant::class, 3);

        $participant = Participant::first();

        $this->assertEquals(15 + 15 + 10 + 50, $participant->total_price);
    }

    public function test_it_can_assign_correct_price_for_non_member()
    {
        $staff = Staff::factory()->create();

        $response = $this->post(route('registration_create'), [
            'name' => 'zaiman',
            'staff_id' => $staff->staff_id,
            'email' => 'rognales@gmail.com',
            'is_vege' => '1',
            'dependant_relationship' => ['Spouse'],
            'dependant_name' => ['Waifu'],
            'dependant_age' => ['22'],
        ]);

        $response->assertSessionDoesntHaveErrors();
        $this->assertDatabaseCount(Participant::class, 1);
        $this->assertDatabaseCount(Dependant::class, 1);

        $participant = Participant::first();

        $this->assertEquals(25 + 25, $participant->total_price);
    }

    public function test_it_can_assign_correct_price_for_non_member_with_free_dependants()
    {
        $staff = Staff::factory()->create();

        $response = $this->post(route('registration_create'), [
            'name' => 'zaiman',
            'staff_id' => $staff->staff_id,
            'email' => 'rognales@gmail.com',
            'is_vege' => '1',
            'dependant_relationship' => ['Spouse', 'Infant', 'OKU'],
            'dependant_name' => ['Waifu', 'Anakku', 'Anak Syurga'],
            'dependant_age' => ['22', '2', '14'],
        ]);

        $response->assertSessionDoesntHaveErrors();
        $this->assertDatabaseCount(Participant::class, 1);
        $this->assertDatabaseCount(Dependant::class, 3);

        $participant = Participant::first();

        $this->assertEquals(25 + 25 + 0 + 0, $participant->total_price);
    }

    public function test_it_can_assign_correct_price_for_non_member_with_paying_dependants()
    {
        $staff = Staff::factory()->create();

        $response = $this->post(route('registration_create'), [
            'name' => 'zaiman',
            'staff_id' => $staff->staff_id,
            'email' => 'rognales@gmail.com',
            'is_vege' => '1',
            'dependant_relationship' => ['Spouse', 'Kids', 'Others'],
            'dependant_name' => ['Waifu', 'Anakku', 'Anak Jiran'],
            'dependant_age' => ['22', '4', '14'],
        ]);

        $response->assertSessionDoesntHaveErrors();
        $this->assertDatabaseCount(Participant::class, 1);
        $this->assertDatabaseCount(Dependant::class, 3);

        $participant = Participant::first();

        $this->assertEquals(25 + 25 + 10 + 50, $participant->total_price);
    }

    public function test_it_should_redirect_to_show_page_after_registration()
    {
        $staff = Staff::factory()->create();

        $response = $this->post(route('registration_create'), [
            'name' => 'zaiman',
            'staff_id' => $staff->staff_id,
            'email' => 'rognales@gmail.com',
            'is_vege' => '1',
            'dependant_relationship' => ['Spouse', 'Kids', 'Others'],
            'dependant_name' => ['Waifu', 'Anakku', 'Anak Jiran'],
            'dependant_age' => ['22', '4', '14'],
        ]);

        $participant = Participant::first();

        $response->assertSessionDoesntHaveErrors();
        $response->assertRedirect(route('registration_show', ['slug' => $participant->slug()]));
    }

    public function test_it_should_store_permalink()
    {
        $participant = Participant::factory()->create();
        $slug = route('registration_show', $participant);

        $this->assertEquals($slug, $participant->permalink);
    }

    public function test_it_should_not_change_price_on_update()
    {
        $participant = Participant::factory()->createQuietly(['price' => 5000]);

        $participant->payment_details = 'cubaan update';
        $participant->timestamps = false;
        $participant->saveQuietly();

        $participant->refresh();

        $this->assertEquals(5000, $participant->getRawOriginal('price'));
    }

    public function test_it_should_not_update_price_if_listener_is_skipped()
    {
        $participant = Participant::factory()->createQuietly();

        $this->assertEquals(null, $participant->getRawOriginal('price'));
    }
}
