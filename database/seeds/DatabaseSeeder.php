<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'Zaiman Noris',
            'username' => 'rognales',
            'email' => 'rognales@gmail.com',
            'password' => Hash::make('password'),
            'active' => true,
        ]);

        factory(User::class)->create([
            'name' => 'Affiq Rashid',
            'username' => 'affiqr',
            'email' => 'sonic21danger@gmail.com',
            'password' => Hash::make('password'),
            'active' => true,
        ]);
    }
}
