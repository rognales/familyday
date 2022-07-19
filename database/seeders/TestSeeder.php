<?php

namespace Database\Seeders;

use App\Member;
use App\Staff;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (app()->isProduction()) {
            return;
        }

        Member::factory()->count(10)->create();
        Staff::factory()->count(10)->create();
    }
}
