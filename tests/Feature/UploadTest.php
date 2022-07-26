<?php

namespace Tests\Feature;

use App\Participant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UploadTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_should_have_valid_form()
    {
        $response = $this->get('/participant/this-is-slug/upload');
        $response->assertNotFound();
    }

    public function test_is_should_validate_record()
    {
        $participant = Participant::factory()->create();

        $response = $this->get(route('registration_show', $participant));

        $response->assertSee($participant->name);
    }
}
