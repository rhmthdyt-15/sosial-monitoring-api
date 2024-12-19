<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Admin Pusat',
                'email' => 'monitoringsosial@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin_pusat',
                'wilayah' => null,
            ],
            [
                'name' => 'Pengguna Daerah',
                'email' => 'penggunadaerah@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'pengguna_daerah',
                'wilayah' => json_encode(['Provinsi Jawa Barat', 'Kabupaten Bandung']),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}