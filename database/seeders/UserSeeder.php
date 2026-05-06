<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Utente amministratore
        User::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'amministratore',
            ]
        );

        // Utente operatore
        User::updateOrCreate(
            ['email' => 'operatore@test.com'],
            [
                'name' => 'Operatore',
                'password' => Hash::make('password'),
                'role' => 'operatore',
            ]
        );
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