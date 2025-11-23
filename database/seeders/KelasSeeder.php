<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kelas')->insert([
            [
                'name' => 'Desain Grafis',
                'description' => 'Kelas pengenalan dasar desain grafis menggunakan tools seperti Photoshop dan Illustrator.',
                'instructor' => 'Budi Santoso',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pemrograman Dasar',
                'description' => 'Belajar dasar pemrograman menggunakan bahasa Python untuk pemula.',
                'instructor' => 'Ika Pratiwi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Editing Video',
                'description' => 'Kelas editing video menggunakan Adobe Premiere dan teknik storytelling visual.',
                'instructor' => 'Rama Wijaya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Public Speaking',
                'description' => 'Pelatihan public speaking, teknik bicara, dan management panggung untuk pemula.',
                'instructor' => 'Sinta Dewi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
