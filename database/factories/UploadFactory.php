<?php

namespace Database\Factories;

use App\User;
use App\Participant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Upload>
 */
class UploadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'amount' => $this->faker->randomDigitNotZero(),
            'reference' => $this->faker->text(10),
            'participant_id' => Participant::factory(),
            'filename' => $this->faker->filePath(),
            'paid_at' => $this->faker->dateTimeThisMonth(),
        ];
    }
}
