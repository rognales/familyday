<?php

namespace Tests\Feature;

use App\Participant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UploadTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_is_should_validate_record()
    {
        $participant = Participant::factory()->create();

        $response = $this->post(route('registration_upload_store', ['slug' => $participant->slug()]), [
            'amount' => 112,
            'reference' => 'this is a reference number',
            'paid_at' => now()->subDay(),
            'filename' => UploadedFile::fake()->create('document.pdf', $sizeInKilobytes = 2000),
        ]);

        $response->assertSessionDoesntHaveErrors();
    }

    public function test_is_should_handle_invalid_upload()
    {
        $participant = Participant::factory()->create();

        $response = $this->post(route('registration_upload_store', ['slug' => $participant->slug()]), [
            'amount' => 112,
            'reference' => null,
            'paid_at' => now()->addDay(),
            'filename' => UploadedFile::fake()->create('document.pdf', $sizeInKilobytes = 3000),
        ]);

        $response->assertInvalid(['reference', 'paid_at', 'filename']);
    }
}
