<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert admin data
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'isAdmin' => true,
            'password' => Hash::make('admin123'), // Hash the password
            'address' => 'JL. Karimun Jawa perumahan taman seruni indah',
            'remember_token' => Str::random(10),
        ]);

        // You can add more admin data if needed
    }
}
