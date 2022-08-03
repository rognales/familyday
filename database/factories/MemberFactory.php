<?php

namespace Database\Factories;

use App\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Member>
 */
class MemberFactory extends Factory
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
     * Indicate that the member is HQ staff.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function belongToHq()
    {
        return $this->state(function (array $attributes) {
            Staff::factory()->create(['staff_id' => $attributes['staff_id']]);

            return [];
        });
    }
}
