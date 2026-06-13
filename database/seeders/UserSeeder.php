<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    // 3 Akun Karyawan
    $karyawans = [
        ['name' => 'Karyawan Satu', 'email' => 'karyawan1@test.com'],
        ['name' => 'Karyawan Dua', 'email' => 'karyawan2@test.com'],
        ['name' => 'Karyawan Tiga', 'email' => 'karyawan3@test.com'],
    ];

    foreach ($karyawans as $k) {
        \App\Models\User::updateOrCreate(
            ['email' => $k['email']],
            ['name' => $k['name'], 'password' => bcrypt('password'), 'role' => 'karyawan']
        );
    }

    // Akun Client (1 saja sebagai default)
    \App\Models\User::updateOrCreate(
        ['email' => 'client@test.com'],
        ['name' => 'Client Default', 'password' => bcrypt('password'), 'role' => 'client']
    );

    // 3 Akun Pekerja Tambahan
    $pekerjas = [
        ['name' => 'Pekerja Satu', 'email' => 'pekerja1@test.com'],
        ['name' => 'Pekerja Dua', 'email' => 'pekerja2@test.com'],
        ['name' => 'Pekerja Tiga', 'email' => 'pekerja3@test.com'],
    ];

    foreach ($pekerjas as $p) {
        \App\Models\User::updateOrCreate(
            ['email' => $p['email']],
            ['name' => $p['name'], 'password' => bcrypt('password'), 'role' => 'pekerjaTambahan']
        );
    }
}
}
