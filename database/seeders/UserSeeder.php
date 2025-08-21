<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_admin' => true,
        ]);

        // Create regular user
        User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}