<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Richiama il seeder degli utenti
        $this->call(UserSeeder::class);
    }
}


/*

ADMIN
email: admin@test.com
password: password

OPERATORE
email: operatore@test.com
password: password

*/