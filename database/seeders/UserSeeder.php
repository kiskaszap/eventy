<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role_id' => 1, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vendor User',
                'email' => 'vendor@example.com',
                'password' => Hash::make('password'),
                'role_id' => 2, // Vendor
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
                'role_id' => 3, // User
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
