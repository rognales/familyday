<?php

namespace Database\Factories;

use App\Dependant;
use App\Member;
use App\Participant;
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
