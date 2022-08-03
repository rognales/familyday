<?php

namespace Database\Factories;

use App\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Staff>
 */
class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'staff_id' => $this->faker->unique()->numerify('TM1####'),
        ];
    }

    /**
     * Indicate that the staff is member.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function member()
    {
        return $this->state(function (array $attributes) {
            Member::factory()->create(['staff_id' => $attributes['staff_id']]);

            return [];
        });
    }
}
