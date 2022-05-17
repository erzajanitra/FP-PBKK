<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // supaya bisa langsung login
        User::create([
            'name' => 'Erza',
            'email' => 'aaa@gmail.com',
            'password' => bcrypt('aaa12345'),
        ]);
    }
}
