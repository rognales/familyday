<?php

namespace Database\Factories;

use App\Dependant;
use App\Member;
use App\Participant;
use App\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Participant>
 */
class ParticipantFactory extends Factory
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
            'staff_id' => $this->faker->numerify('TM1####'),
            'email' => $this->faker->safeEmail(),
            'division' => $this->faker->company(),
            'member' => $this->faker->boolean(),
            'is_vege' => $this->faker->boolean(),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Participant $participant) {
            if ($participant->isMember()) {
                Member::factory()->create(['staff_id' => $participant->staff_id]);
            }
        });
    }

    /**
     * Indicate that the participant is member.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function member()
    {
        return $this->state(function (array $attributes) {
            return [
                'member' => true,
            ];
        });
    }

    /**
     * Indicate that the participant is non-member.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function nonMember()
    {
        return $this->state(function (array $attributes) {
            return [
                'member' => false,
            ];
        });
    }

    /**
     * Indicate that the participant is HQ staff.
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

    public function addSpouse(int $count = null): self
    {
        $count = $count ?? rand(0, 1);

        return $this->afterCreating(
        fn (Participant $participant) => Dependant::factory()
        ->count($count)
        ->for($participant)
        ->create(['relationship' => 'Spouse'])
        );
    }

    public function addChildren(int $count = null): self
    {
        $count = $count ?? rand(0, 3);

        return $this->afterCreating(
        fn (Participant $participant) => Dependant::factory()
        ->count($count)
        ->for($participant)
        ->create(['relationship' => 'Kids'])
        );
    }

    public function addInfant(int $count = null): self
    {
        $count = $count ?? rand(0, 1);

        return $this->afterCreating(
        fn (Participant $participant) => Dependant::factory()
        ->count($count)
        ->for($participant)
        ->create(['relationship' => 'Infant'])
        );
    }

    public function addOthers(int $count = null): self
    {
        $count = $count ?? rand(0, 2);

        return $this->afterCreating(
        fn (Participant $participant) => Dependant::factory()
        ->count($count)
        ->for($participant)
        ->create(['relationship' => 'Others'])
        );
    }
}
