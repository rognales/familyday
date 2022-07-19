<?php

namespace Database\Seeders;

use App\User;
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
        User::factory()->create([
            'name' => 'Zaiman Noris',
            'username' => 'rognales',
            'email' => 'rognales@gmail.com',
            'password' => Hash::make('password'),
            'active' => true,
        ]);

        User::factory()->create([
            'name' => 'Affiq Rashid',
            'username' => 'affiqr',
            'email' => 'sonic21danger@gmail.com',
            'password' => Hash::make('password'),
            'active' => true,
        ]);
    }
}
