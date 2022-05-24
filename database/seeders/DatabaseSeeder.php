<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Article;

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
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'isAdmin' => '1',
            'password' => bcrypt('admin123'),
        ]);

        // factory artikel
        Article::factory(15)->create();
		
		// contoh pricelist
        Pricelist::create([
            'name' => 'Paket Terusan',
            'price' => '500000'
        ]);

        Pricelist::create([
            'name' => 'Paket Reguler',
            'price' => '80000'
        ]);
    }
}
