<?php

namespace Database\Seeders;

use Carbon\Carbon as CarbonCarbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BantuanProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $programs = [
            [
                'name' => 'Bantuan Sosial Tunai',
                'description' => 'Program bantuan tunai untuk masyarakat terdampak pandemi.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Bantuan Pangan Non Tunai',
                'description' => 'Program distribusi bantuan pangan untuk masyarakat kurang mampu.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Bantuan Pendidikan',
                'description' => 'Program bantuan untuk mendukung kebutuhan pendidikan.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Bantuan UMKM',
                'description' => 'Bantuan modal usaha untuk pelaku UMKM.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Bantuan Bencana Alam',
                'description' => 'Bantuan untuk masyarakat terdampak bencana alam.',
                'created_at' => CarbonCarbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('bantuan_programs')->insert($programs);
    }
}