<?php

namespace Database\Factories;

use App\Participant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Dependant>
 */
class DependantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $relationships = ['Spouse', 'Kids', 'Infant', 'Others'];

        $age = [
            'Spouse' => $this->faker->numberBetween(23, 60),
            'Kids' => $this->faker->numberBetween(3, 21),
            'Infant' => $this->faker->numberBetween(0, 2),
            'Others' => $this->faker->numberBetween(0, 60),

        ];

        return [
            'name' => $this->faker->name(),
            'relationship' => $this->faker->randomElement($relationships),
            'age' => fn (array $attributes) => $age[$attributes['relationship']],
            'participant_id' => Participant::factory(),
            'staff_id' => function (array $attributes) {
                return Participant::find($attributes['participant_id'])->staff_id;
            },
        ];
    }
}
