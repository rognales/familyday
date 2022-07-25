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
            'member' => function (array $attributes) {
                return Participant::find($attributes['participant_id'])->member;
            },
        ];
    }

    /**
     * Indicate that the dependant is spouse.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function spouse()
    {
        return $this->state(function (array $attributes) {
            return [
                'relationship' => 'Spouse',
                'age' => $this->faker->numberBetween(18, 50),
            ];
        });
    }

    /**
     * Indicate that the dependant is kids.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function kids()
    {
        return $this->state(function (array $attributes) {
            return [
                'relationship' => 'Kids',
                'age' => $this->faker->numberBetween(3, 12),
            ];
        });
    }

    /**
     * Indicate that the dependant is infant.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function infant()
    {
        return $this->state(function (array $attributes) {
            return [
                'relationship' => 'Infant',
                'age' => $this->faker->numberBetween(0, 2),
            ];
        });
    }

    /**
     * Indicate that the dependant is others.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function others()
    {
        return $this->state(function (array $attributes) {
            return [
                'relationship' => 'Others',
            ];
        });
    }

    /**
     * Indicate that the dependant is adult.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function adult()
    {
        return $this->state(function (array $attributes) {
            return [
                'age' => $this->faker->numberBetween(14, 60),
            ];
        });
    }

    /**
     * Indicate that the dependant is child.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function child()
    {
        return $this->state(function (array $attributes) {
            return [
                'age' => $this->faker->numberBetween(4, 13),
            ];
        });
    }
}
