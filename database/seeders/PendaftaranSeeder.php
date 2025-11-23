<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Peserta 1 → kelas 1
        DB::table('pendaftaran')->insert([
            'user_id' => 2,
            'kelas_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Peserta 1 → kelas 2
        DB::table('pendaftaran')->insert([
            'user_id' => 2,
            'kelas_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Peserta 2 → kelas 3
        DB::table('pendaftaran')->insert([
            'user_id' => 3,
            'kelas_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Peserta 3 → kelas 1
        DB::table('pendaftaran')->insert([
            'user_id' => 4,
            'kelas_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Peserta 3 → kelas 2
        DB::table('pendaftaran')->insert([
            'user_id' => 4,
            'kelas_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Peserta 3 → kelas 3
        DB::table('pendaftaran')->insert([
            'user_id' => 4,
            'kelas_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Peserta 3 → kelas 4
        DB::table('pendaftaran')->insert([
            'user_id' => 4,
            'kelas_id' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Peserta 4 → no insert (tidak ikut kelas)
    }
}
