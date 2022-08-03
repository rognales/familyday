<?php

namespace Tests\Unit;

use App\Dependant;
use App\Participant;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EntranceRateTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_members_without_dependant()
    {
        $member = Participant::factory()->member()->create();

        $this->assertEquals(15, $member->total_price);
    }

    public function test_members_with_spouse()
    {
        $member = Participant::factory()->member()->create();

        Dependant::factory()->for($member)->spouse()->create();

        $this->assertEquals(15 + 15, $member->total_price);
    }

    public function test_members_with_family()
    {
        $member = Participant::factory()->member()->create();

        Dependant::factory()
            ->for($member)
            ->count(4)
            ->state(new Sequence(
                ['relationship' => 'Spouse', 'age' => 20],
                ['relationship' => 'Kids', 'age' => 11],
                ['relationship' => 'Kids', 'age' => 5],
                ['relationship' => 'Infant', 'age' => 1],
            ))
            ->create();

        $this->assertEquals(15 + 15 + 10 + 10 + 0, $member->total_price);
    }

    public function test_members_with_family_and_others()
    {
        $member = Participant::factory()->member()->create();

        Dependant::factory()
            ->for($member)
            ->count(6)
            ->state(new Sequence(
                ['relationship' => 'Spouse', 'age' => 20],
                ['relationship' => 'Kids', 'age' => 11],
                ['relationship' => 'Kids', 'age' => 5],
                ['relationship' => 'Infant', 'age' => 1],
                ['relationship' => 'Others', 'age' => 14],
                ['relationship' => 'Others', 'age' => 4],
            ))
            ->create();

        $this->assertEquals(15 + 15 + 10 + 10 + 0 + 50 + 20, $member->total_price);
    }

    public function test_non_members_without_dependant()
    {
        $nonMember = Participant::factory()->nonMember()->create();

        $this->assertEquals(50, $nonMember->total_price);
    }

    public function test_non_members_with_spouse()
    {
        $nonMember = Participant::factory()->nonMember()->create();

        Dependant::factory()->for($nonMember)->spouse()->create();

        $this->assertEquals(50 + 50, $nonMember->total_price);
    }

    public function test_non_members_with_family()
    {
        $nonMember = Participant::factory()->nonMember()->create();

        Dependant::factory()
            ->for($nonMember)
            ->count(4)
            ->state(new Sequence(
                ['relationship' => 'Spouse', 'age' => 20],
                ['relationship' => 'Kids', 'age' => 11],
                ['relationship' => 'Kids', 'age' => 5],
                ['relationship' => 'Infant', 'age' => 1],
            ))
            ->create();

        $this->assertEquals(50 + 50 + 20 + 20 + 0, $nonMember->total_price);
    }

    public function test_non_members_with_family_and_others()
    {
        $nonMember = Participant::factory()->nonMember()->create();

        Dependant::factory()
            ->for($nonMember)
            ->count(6)
            ->state(new Sequence(
                ['relationship' => 'Spouse', 'age' => 20],
                ['relationship' => 'Kids', 'age' => 11],
                ['relationship' => 'Kids', 'age' => 5],
                ['relationship' => 'Infant', 'age' => 1],
                ['relationship' => 'Others', 'age' => 14],
                ['relationship' => 'Others', 'age' => 4],
            ))
            ->create();

        $this->assertEquals(50 + 50 + 20 + 20 + 0 + 50 + 20, $nonMember->total_price);
    }

    public function test_members_with_family_and_oku()
    {
        $member = Participant::factory()->member()->create();

        Dependant::factory()
            ->for($member)
            ->count(5)
            ->state(new Sequence(
                ['relationship' => 'Spouse', 'age' => 20],
                ['relationship' => 'Kids', 'age' => 11],
                ['relationship' => 'Kids', 'age' => 5],
                ['relationship' => 'Infant', 'age' => 1],
                ['relationship' => 'Oku', 'age' => 14],
            ))
            ->create();

        $this->assertEquals(15 + 15 + 10 + 10 + 0 + 0, $member->total_price);
    }

    public function test_non_members_with_family_and_oku()
    {
        $nonMember = Participant::factory()->nonMember()->create();

        Dependant::factory()
            ->for($nonMember)
            ->count(5)
            ->state(new Sequence(
                ['relationship' => 'Spouse', 'age' => 20],
                ['relationship' => 'Kids', 'age' => 11],
                ['relationship' => 'Kids', 'age' => 5],
                ['relationship' => 'Infant', 'age' => 1],
                ['relationship' => 'Oku', 'age' => 14],
            ))
            ->create();

        $this->assertEquals(50 + 50 + 20 + 20 + 0 + 0, $nonMember->total_price);
    }
}
