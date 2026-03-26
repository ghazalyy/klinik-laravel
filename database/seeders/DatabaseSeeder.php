<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Dokter;
use App\Models\JadwalDokter;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::firstOrCreate(['username' => 'admin'], [
            'nama_lengkap' => 'Administrator',
            'username'     => 'admin',
            'password'     => Hash::make('password123'),
            'role'         => 'admin',
        ]);

        // Dokter 1
        $user1 = User::firstOrCreate(['username' => 'dokter1'], [
            'nama_lengkap' => 'Dr. Budi Santoso',
            'username'     => 'dokter1',
            'password'     => Hash::make('password123'),
            'role'         => 'dokter',
        ]);

        if (!$user1->dokter) {
            $dokter1 = Dokter::create([
                'user_id'       => $user1->id,
                'spesialisasi'  => 'Dokter Umum',
                'deskripsi'     => 'Berpengalaman menangani berbagai keluhan kesehatan umum.',
                'harga_sesi'    => 75000,
                'status_online' => 'Online',
            ]);

            JadwalDokter::insert([
                ['dokter_id' => $dokter1->id, 'hari' => 'Senin',  'jam_mulai' => '08:00:00', 'jam_selesai' => '12:00:00', 'jenis_layanan' => 'Offline', 'created_at' => now(), 'updated_at' => now()],
                ['dokter_id' => $dokter1->id, 'hari' => 'Senin',  'jam_mulai' => '13:00:00', 'jam_selesai' => '15:00:00', 'jenis_layanan' => 'Online',  'created_at' => now(), 'updated_at' => now()],
                ['dokter_id' => $dokter1->id, 'hari' => 'Selasa', 'jam_mulai' => '08:00:00', 'jam_selesai' => '12:00:00', 'jenis_layanan' => 'Offline', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        // Dokter 2
        $user2 = User::firstOrCreate(['username' => 'dokter2'], [
            'nama_lengkap' => 'Drg. Siti Aisyah',
            'username'     => 'dokter2',
            'password'     => Hash::make('password123'),
            'role'         => 'dokter',
        ]);

        if (!$user2->dokter) {
            $dokter2 = Dokter::create([
                'user_id'       => $user2->id,
                'spesialisasi'  => 'Dokter Gigi',
                'deskripsi'     => 'Ahli bedah mulut dan estetika gigi.',
                'harga_sesi'    => 150000,
                'status_online' => 'Offline',
            ]);

            JadwalDokter::insert([
                ['dokter_id' => $dokter2->id, 'hari' => 'Rabu',  'jam_mulai' => '09:00:00', 'jam_selesai' => '14:00:00', 'jenis_layanan' => 'Offline', 'created_at' => now(), 'updated_at' => now()],
                ['dokter_id' => $dokter2->id, 'hari' => 'Kamis', 'jam_mulai' => '15:00:00', 'jam_selesai' => '18:00:00', 'jenis_layanan' => 'Online',  'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        // Pasien 1
        User::firstOrCreate(['username' => 'pasien1'], [
            'nama_lengkap' => 'Andi Setiawan',
            'username'     => 'pasien1',
            'password'     => Hash::make('password123'),
            'role'         => 'pasien',
        ]);

        // Pasien 2
        User::firstOrCreate(['username' => 'pasien2'], [
            'nama_lengkap' => 'Rina Melati',
            'username'     => 'pasien2',
            'password'     => Hash::make('password123'),
            'role'         => 'pasien',
        ]);
    }
}
