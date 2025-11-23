<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        DB::table('users')->insert([
            'name' => 'Admin SkillHub',
            'email' => 'admin@skillhub.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Peserta 1
        DB::table('users')->insert([
            'name' => 'Alif Rahman',
            'email' => 'alif.rahman@example.com',
            'password' => Hash::make('password123'),
            'role' => 'peserta',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Peserta 2
        DB::table('users')->insert([
            'name' => 'Nadia Putri',
            'email' => 'nadia.putri@example.com',
            'password' => Hash::make('password123'),
            'role' => 'peserta',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Peserta 3
        DB::table('users')->insert([
            'name' => 'Rizky Pratama',
            'email' => 'rizky.pratama@example.com',
            'password' => Hash::make('password123'),
            'role' => 'peserta',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Peserta 4
        DB::table('users')->insert([
            'name' => 'Sabrina Anggraini',
            'email' => 'sabrina.anggraini@example.com',
            'password' => Hash::make('password123'),
            'role' => 'peserta',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
