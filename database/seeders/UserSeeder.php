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
    // 4 Akun Karyawan
    $karyawans = [
        ['name' => 'Karyawan', 'email' => 'karyawan@test.com'],
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

    // 4 Akun Client
    $clients = [
        ['name' => 'Client', 'email' => 'client@test.com'],
        ['name' => 'Client Satu', 'email' => 'client1@test.com'],
        ['name' => 'Client Dua', 'email' => 'client2@test.com'],
        ['name' => 'Client Tiga', 'email' => 'client3@test.com'],
    ];

    foreach ($clients as $c) {
        \App\Models\User::updateOrCreate(
            ['email' => $c['email']],
            ['name' => $c['name'], 'password' => bcrypt('password'), 'role' => 'client']
        );
    }

    // 4 Akun Pekerja Tambahan
    $pekerjas = [
        ['name' => 'Pekerja', 'email' => 'pekerja@test.com'],
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
