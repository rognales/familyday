<?php

namespace Database\Seeders;

use App\User;
use App\Staff;
use App\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Admins
        User::factory()->create([
            'name' => 'Zaiman Noris',
            'username' => 'rognales',
            'email' => 'rognales@gmail.com',
            'active' => true,
        ]);

        User::factory()->create([
            'name' => 'Affiq Rashid',
            'username' => 'affiqr',
            'email' => 'sonic21danger@gmail.com',
            'active' => true,
        ]);

        // Only seed test data in non-prod
        if (!app()->isProduction()) {
            Member::factory()->count(10)->create();
            Staff::factory()->count(10)->create();
        }
    }
}
