<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationFormTest extends TestCase
{
    public function test_it_should_display_correct_price_on_form_for_adult()
    {
        $response = $this->get(route('registration_home'));

        $response->assertSeeInOrder([
            'Adult',
            '(age 13 & above)',
            config('familyday.rate.adult.member') / 100,
            config('familyday.rate.adult.nonmember_old') / 100,
            config('familyday.rate.adult.nonmember') / 100,
        ]);
    }

    public function test_it_should_display_correct_price_on_form_for_kids()
    {
        $response = $this->get(route('registration_home'));

        $response->assertSeeInOrder([
            'Kids',
            '(age 4-12 years old)',
            config('familyday.rate.kids.member') / 100,
            config('familyday.rate.kids.nonmember_old') / 100,
            config('familyday.rate.kids.nonmember') / 100,
        ]);
    }

    public function test_it_should_display_correct_price_on_form_for_infant()
    {
        $response = $this->get(route('registration_home'));

        $response->assertSeeInOrder([
            'Infant',
            '(age 0-3 years old)',
            'Free',
            'Free'
        ]);
    }

    public function test_it_should_display_correct_price_on_form_for_others_adult()
    {
        $response = $this->get(route('registration_home'));

        $response->assertSeeInOrder([
            'Adult',
            '(age 13 & above)',
            config('familyday.rate.adult.others') / 100,
            config('familyday.rate.adult.others') / 100,
        ]);
    }

    public function test_it_should_display_correct_price_on_form_for_others_kids()
    {
        $response = $this->get(route('registration_home'));

        $response->assertSeeInOrder([
            'Kids',
            '(age 4-12 years old)',
            config('familyday.rate.kids.others') / 100,
            config('familyday.rate.kids.others') / 100,
        ]);
    }
}
