<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);

        // Kasir
        User::create([
            'name' => 'Kasir 1',
            'username' => 'arisetyawan',
            'password' => Hash::make('ari123'),
            'role' => 'kasir',
        ]);
    }
}
