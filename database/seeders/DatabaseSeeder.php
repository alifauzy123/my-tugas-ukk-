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
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin',
                'password' => Hash::make('123456'),
                'role' => 'admin',
            ]
        );

        // Owner
        User::updateOrCreate(
            ['username' => 'owner321'],
            [
                'name' => 'Owner',
                'password' => Hash::make('owner123'),
                'role' => 'owner',
            ]
        );
    }
}
