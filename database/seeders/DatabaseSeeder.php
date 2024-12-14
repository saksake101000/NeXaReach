<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Seed for 'users' table
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@nexareach.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seed for 'password_reset_tokens' table
        DB::table('password_reset_tokens')->insert([
            'email' => 'admin@nexareach.com',
            'token' => Str::random(60),
            'created_at' => now(),
        ]);

        // Seed for 'sessions' table
        DB::table('sessions')->insert([
            'id' => Str::random(40),
            'user_id' => 1, // Assuming the admin user has id = 1
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'payload' => json_encode(['key' => 'value']),
            'last_activity' => time(),
        ]);
    }
}
