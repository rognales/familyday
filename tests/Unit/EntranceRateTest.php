<?php

namespace Tests\Unit;

use Tests\TestCase;
use Tests\CreatesApplication;
use App\Services\EntranceRate;
use Illuminate\Foundation\Testing\WithFaker;

class EntranceRateTest extends TestCase
{
    use CreatesApplication;
    use WithFaker;

    public function test_it_should_properly_rate_member()
    {
        $rateAdult = EntranceRate::calculate($this->faker->numberBetween(13, 60), $member = true);
        $rateKids = EntranceRate::calculate($this->faker->numberBetween(4, 12), $member = true);
        $rateInfant = EntranceRate::calculate($this->faker->numberBetween(1, 3), $member = true);

        $this->assertEquals(config('familyday.rate.adult.member'), $rateAdult);
        $this->assertEquals(config('familyday.rate.kids.member'), $rateKids);
        $this->assertEquals(0, $rateInfant);
    }

    public function test_it_should_properly_rate_non_member()
    {
        $rateAdult = EntranceRate::calculate($this->faker->numberBetween(13, 60), $member = false);
        $rateKids = EntranceRate::calculate($this->faker->numberBetween(4, 12), $member = false);
        $rateInfant = EntranceRate::calculate($this->faker->numberBetween(1, 3), $member = false);

        $this->assertEquals(config('familyday.rate.adult.nonmember'), $rateAdult);
        $this->assertEquals(config('familyday.rate.kids.nonmember'), $rateKids);
        $this->assertEquals(0, $rateInfant);
    }

    public function test_it_should_properly_rate_others_for_member()
    {
        $rateAdult = EntranceRate::calculate($this->faker->numberBetween(13, 60), $member = true, $others = true);
        $rateKids = EntranceRate::calculate($this->faker->numberBetween(4, 12), $member = true, $others = true);
        $rateInfant = EntranceRate::calculate($this->faker->numberBetween(1, 3), $member = true, $others = true);

        $this->assertEquals(config('familyday.rate.adult.others'), $rateAdult);
        $this->assertEquals(config('familyday.rate.kids.others'), $rateKids);
        $this->assertEquals(0, $rateInfant);
    }

    public function test_it_should_properly_rate_others_for_non_member()
    {
        $rateAdult = EntranceRate::calculate($this->faker->numberBetween(13, 60), $member = false, $others = true);
        $rateKids = EntranceRate::calculate($this->faker->numberBetween(4, 12), $member = false, $others = true);
        $rateInfant = EntranceRate::calculate($this->faker->numberBetween(1, 3), $member = false, $others = true);

        $this->assertEquals(config('familyday.rate.adult.others'), $rateAdult);
        $this->assertEquals(config('familyday.rate.kids.others'), $rateKids);
        $this->assertEquals(0, $rateInfant);
    }
}
