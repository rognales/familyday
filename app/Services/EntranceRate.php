<?php

namespace App\Services;

class EntranceRate
{
    public static function calculate(int $age, $isMember = false, $others = false): int
    {
        // others
        if ($others && $age >= 13) {
            return config('familyday.rate.adult.others');
        }

        if ($others && $age < 13 && $age > 3) {
            return config('familyday.rate.kids.others');
        }

        // family
        if ($age >= 13) {
            return $isMember ? config('familyday.rate.adult.member') : config('familyday.rate.adult.nonmember');
        }

        if ($age < 13 && $age > 3) {
            return $isMember ? config('familyday.rate.kids.member') : config('familyday.rate.kids.nonmember');
        }

        // All thats left is infant
        return config('familyday.rate.infant.others');
    }
}
