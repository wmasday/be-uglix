<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password_hash' => Hash::make('admin123'),
                'full_name' => 'Admin User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'john',
                'email' => 'john@example.com',
                'password_hash' => Hash::make('password'),
                'full_name' => 'John Doe',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}


