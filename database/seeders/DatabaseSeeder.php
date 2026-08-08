<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Dokter;
use App\Models\JadwalDokter;
use App\Models\Booking;
use App\Models\Pembayaran;
use App\Models\AntreanOffline;
use App\Models\RekamMedis;
use App\Models\ReviewDokter;
use App\Models\SurveiKepuasan;
use App\Models\Chat;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. User Admin
        $admin = User::firstOrCreate(['username' => 'admin'], [
            'nama_lengkap' => 'Administrator Utama',
            'username'     => 'admin',
            'password'     => Hash::make('password123'),
            'role'         => 'admin',
        ]);

        // 2. Dokter (5 Dokter)
        $dokterData = [
            [
                'username'     => 'dokter1',
                'nama'         => 'Dr. Budi Santoso',
                'spesialisasi'  => 'Dokter Umum',
                'deskripsi'     => 'Berpengalaman 10 tahun menangani berbagai keluhan kesehatan umum dan penyakit harian.',
                'harga_sesi'    => 75000,
                'status_online' => 'Online',
                'jadwal'        => [
                    ['hari' => 'Senin', 'jam_mulai' => '08:00:00', 'jam_selesai' => '12:00:00', 'jenis' => 'Offline'],
                    ['hari' => 'Senin', 'jam_mulai' => '13:00:00', 'jam_selesai' => '16:00:00', 'jenis' => 'Online'],
                    ['hari' => 'Rabu',  'jam_mulai' => '08:00:00', 'jam_selesai' => '12:00:00', 'jenis' => 'Offline'],
                    ['hari' => 'Jumat', 'jam_mulai' => '13:00:00', 'jam_selesai' => '17:00:00', 'jenis' => 'Online'],
                ]
            ],
            [
                'username'     => 'dokter2',
                'nama'         => 'Drg. Siti Aisyah',
                'spesialisasi'  => 'Dokter Gigi',
                'deskripsi'     => 'Ahli perawatan estetika gigi, pencabutan, dan pembersihan karang gigi profesional.',
                'harga_sesi'    => 150000,
                'status_online' => 'Offline',
                'jadwal'        => [
                    ['hari' => 'Selasa', 'jam_mulai' => '09:00:00', 'jam_selesai' => '14:00:00', 'jenis' => 'Offline'],
                    ['hari' => 'Kamis',  'jam_mulai' => '15:00:00', 'jam_selesai' => '18:00:00', 'jenis' => 'Online'],
                    ['hari' => 'Sabtu',  'jam_mulai' => '09:00:00', 'jam_selesai' => '13:00:00', 'jenis' => 'Offline'],
                ]
            ],
            [
                'username'     => 'dokter3',
                'nama'         => 'Dr. Andi Wijaya, Sp.PD',
                'spesialisasi'  => 'Spesialis Penyakit Dalam',
                'deskripsi'     => 'Fokus pada gangguan organ dalam, hipertensi, diabetes, dan penyakit kronis.',
                'harga_sesi'    => 200000,
                'status_online' => 'Online',
                'jadwal'        => [
                    ['hari' => 'Senin', 'jam_mulai' => '10:00:00', 'jam_selesai' => '14:00:00', 'jenis' => 'Offline'],
                    ['hari' => 'Rabu',  'jam_mulai' => '14:00:00', 'jam_selesai' => '18:00:00', 'jenis' => 'Online'],
                    ['hari' => 'Jumat', 'jam_mulai' => '09:00:00', 'jam_selesai' => '12:00:00', 'jenis' => 'Offline'],
                ]
            ],
            [
                'username'     => 'dokter4',
                'nama'         => 'Dr. Maya Indah, Sp.A',
                'spesialisasi'  => 'Spesialis Anak',
                'deskripsi'     => 'Dokter spesialis tumbuh kembang anak, imunisasi, dan kesehatan balita.',
                'harga_sesi'    => 175000,
                'status_online' => 'Online',
                'jadwal'        => [
                    ['hari' => 'Selasa', 'jam_mulai' => '10:00:00', 'jam_selesai' => '15:00:00', 'jenis' => 'Offline'],
                    ['hari' => 'Rabu',  'jam_mulai' => '09:00:00', 'jam_selesai' => '12:00:00', 'jenis' => 'Online'],
                    ['hari' => 'Sabtu',  'jam_mulai' => '10:00:00', 'jam_selesai' => '14:00:00', 'jenis' => 'Offline'],
                ]
            ],
            [
                'username'     => 'dokter5',
                'nama'         => 'Dr. Hendra Pratama, Sp.THT',
                'spesialisasi'  => 'Spesialis THT',
                'deskripsi'     => 'Spesialis penanganan keluhan telinga, hidung, tenggorokan, serta alergi pernapasan.',
                'harga_sesi'    => 180000,
                'status_online' => 'Offline',
                'jadwal'        => [
                    ['hari' => 'Senin', 'jam_mulai' => '14:00:00', 'jam_selesai' => '18:00:00', 'jenis' => 'Online'],
                    ['hari' => 'Kamis', 'jam_mulai' => '09:00:00', 'jam_selesai' => '13:00:00', 'jenis' => 'Offline'],
                    ['hari' => 'Jumat', 'jam_mulai' => '14:00:00', 'jam_selesai' => '17:00:00', 'jenis' => 'Offline'],
                ]
            ],
        ];

        $dokterModels = [];
        $jadwalModels = [];

        foreach ($dokterData as $d) {
            $u = User::firstOrCreate(['username' => $d['username']], [
                'nama_lengkap' => $d['nama'],
                'username'     => $d['username'],
                'password'     => Hash::make('password123'),
                'role'         => 'dokter',
            ]);

            $doc = Dokter::updateOrCreate(['user_id' => $u->id], [
                'spesialisasi'  => $d['spesialisasi'],
                'deskripsi'     => $d['deskripsi'],
                'harga_sesi'    => $d['harga_sesi'],
                'status_online' => $d['status_online'],
            ]);

            $dokterModels[] = $doc;

            foreach ($d['jadwal'] as $j) {
                $jadwalModels[] = JadwalDokter::create([
                    'dokter_id'     => $doc->id,
                    'hari'          => $j['hari'],
                    'jam_mulai'     => $j['jam_mulai'],
                    'jam_selesai'   => $j['jam_selesai'],
                    'jenis_layanan' => $j['jenis'],
                ]);
            }
        }

        // 3. Pasien (20 Pasien)
        $pasienList = [
            ['nama' => 'Ahmad Dahlan',       'username' => 'pasien1',  'days_ago' => 150],
            ['nama' => 'Siti Rahma',          'username' => 'pasien2',  'days_ago' => 140],
            ['nama' => 'Budi Santoso',       'username' => 'pasien3',  'days_ago' => 120],
            ['nama' => 'Dewi Lestari',       'username' => 'pasien4',  'days_ago' => 100],
            ['nama' => 'Eko Prasetyo',       'username' => 'pasien5',  'days_ago' => 95], // CRM Inactive (>90 days without booking)
            ['nama' => 'Fitri Handayani',    'username' => 'pasien6',  'days_ago' => 85],
            ['nama' => 'Gunawan Wibowo',     'username' => 'pasien7',  'days_ago' => 70],
            ['nama' => 'Hesti Pertiwi',      'username' => 'pasien8',  'days_ago' => 60],
            ['nama' => 'Indra Wijaya',       'username' => 'pasien9',  'days_ago' => 50],
            ['nama' => 'Julia Putri',        'username' => 'pasien10', 'days_ago' => 45],
            ['nama' => 'Kurniawan Pratama',  'username' => 'pasien11', 'days_ago' => 40],
            ['nama' => 'Lilis Suryani',      'username' => 'pasien12', 'days_ago' => 30],
            ['nama' => 'Muhammad Rizky',     'username' => 'pasien13', 'days_ago' => 25],
            ['nama' => 'Nurul Hidayah',      'username' => 'pasien14', 'days_ago' => 20],
            ['nama' => 'Bambang Pamungkas',  'username' => 'pasien15', 'days_ago' => 15],
            ['nama' => 'Rina Melati',        'username' => 'pasien16', 'days_ago' => 10],
            ['nama' => 'Slamet Rahardjo',    'username' => 'pasien17', 'days_ago' => 5],
            ['nama' => 'Tri Utami',          'username' => 'pasien18', 'days_ago' => 3],
            ['nama' => 'Wahyu Hidayat',      'username' => 'pasien19', 'days_ago' => 2],
            ['nama' => 'Yulia Ningsih',      'username' => 'pasien20', 'days_ago' => 0], // Baru hari ini
        ];

        $pasienUsers = [];
        foreach ($pasienList as $p) {
            $created = Carbon::now()->subDays($p['days_ago']);
            $u = User::firstOrCreate(['username' => $p['username']], [
                'nama_lengkap' => $p['nama'],
                'username'     => $p['username'],
                'password'     => Hash::make('password123'),
                'role'         => 'pasien',
                'created_at'   => $created,
                'updated_at'   => $created,
            ]);
            $pasienUsers[] = $u;
        }

        // 4. Booking (20 Booking Data spread across 6 months)
        $bookingSeeds = [
            // 5 bulan lalu
            ['pasien_idx' => 0,  'dokter_idx' => 0, 'months_ago' => 5, 'days_offset' => 10, 'pay_status' => 'lunas',     'sesi_status' => 'selesai'],
            ['pasien_idx' => 1,  'dokter_idx' => 1, 'months_ago' => 5, 'days_offset' => 5,  'pay_status' => 'lunas',     'sesi_status' => 'selesai'],
            ['pasien_idx' => 2,  'dokter_idx' => 2, 'months_ago' => 5, 'days_offset' => 2,  'pay_status' => 'lunas',     'sesi_status' => 'selesai'],

            // 4 bulan lalu
            ['pasien_idx' => 3,  'dokter_idx' => 3, 'months_ago' => 4, 'days_offset' => 15, 'pay_status' => 'lunas',     'sesi_status' => 'selesai'],
            ['pasien_idx' => 5,  'dokter_idx' => 4, 'months_ago' => 4, 'days_offset' => 8,  'pay_status' => 'lunas',     'sesi_status' => 'selesai'],
            ['pasien_idx' => 6,  'dokter_idx' => 0, 'months_ago' => 4, 'days_offset' => 3,  'pay_status' => 'lunas',     'sesi_status' => 'selesai'],

            // 3 bulan lalu
            ['pasien_idx' => 7,  'dokter_idx' => 1, 'months_ago' => 3, 'days_offset' => 20, 'pay_status' => 'lunas',     'sesi_status' => 'selesai'],
            ['pasien_idx' => 8,  'dokter_idx' => 2, 'months_ago' => 3, 'days_offset' => 12, 'pay_status' => 'lunas',     'sesi_status' => 'selesai'],
            ['pasien_idx' => 9,  'dokter_idx' => 3, 'months_ago' => 3, 'days_offset' => 4,  'pay_status' => 'ditolak',   'sesi_status' => 'dibatalkan'],

            // 2 bulan lalu
            ['pasien_idx' => 10, 'dokter_idx' => 4, 'months_ago' => 2, 'days_offset' => 18, 'pay_status' => 'lunas',     'sesi_status' => 'selesai'],
            ['pasien_idx' => 11, 'dokter_idx' => 0, 'months_ago' => 2, 'days_offset' => 10, 'pay_status' => 'lunas',     'sesi_status' => 'selesai'],
            ['pasien_idx' => 12, 'dokter_idx' => 1, 'months_ago' => 2, 'days_offset' => 2,  'pay_status' => 'lunas',     'sesi_status' => 'selesai'],

            // 1 bulan lalu
            ['pasien_idx' => 13, 'dokter_idx' => 2, 'months_ago' => 1, 'days_offset' => 22, 'pay_status' => 'lunas',     'sesi_status' => 'selesai'],
            ['pasien_idx' => 14, 'dokter_idx' => 3, 'months_ago' => 1, 'days_offset' => 14, 'pay_status' => 'lunas',     'sesi_status' => 'selesai'],
            ['pasien_idx' => 15, 'dokter_idx' => 0, 'months_ago' => 1, 'days_offset' => 5,  'pay_status' => 'pending',   'sesi_status' => 'menunggu'],

            // Bulan ini (Hari ini & recent)
            ['pasien_idx' => 16, 'dokter_idx' => 0, 'months_ago' => 0, 'days_offset' => 0,  'pay_status' => 'lunas',     'sesi_status' => 'aktif'],
            ['pasien_idx' => 17, 'dokter_idx' => 1, 'months_ago' => 0, 'days_offset' => 0,  'pay_status' => 'lunas',     'sesi_status' => 'menunggu'],
            ['pasien_idx' => 18, 'dokter_idx' => 2, 'months_ago' => 0, 'days_offset' => 0,  'pay_status' => 'pending',   'sesi_status' => 'menunggu'],
            ['pasien_idx' => 19, 'dokter_idx' => 3, 'months_ago' => 0, 'days_offset' => 0,  'pay_status' => 'pending',   'sesi_status' => 'menunggu'],
            ['pasien_idx' => 14, 'dokter_idx' => 4, 'months_ago' => 0, 'days_offset' => 0,  'pay_status' => 'pending',   'sesi_status' => 'menunggu'],
        ];

        $bookingModels = [];

        foreach ($bookingSeeds as $b) {
            $pasien  = $pasienUsers[$b['pasien_idx']];
            $dokter  = $dokterModels[$b['dokter_idx']];
            $jadwal  = JadwalDokter::where('dokter_id', $dokter->id)->first();

            $date = Carbon::now()->subMonths($b['months_ago'])->subDays($b['days_offset']);

            $waktuMulai = null;
            if (in_array($b['sesi_status'], ['aktif', 'selesai'])) {
                $waktuMulai = $date->copy()->setTime(9, 0, 0);
            }

            $booking = Booking::create([
                'pasien_id'         => $pasien->id,
                'dokter_id'         => $dokter->id,
                'jadwal_id'         => $jadwal ? $jadwal->id : null,
                'tanggal_booking'   => $date->toDateString(),
                'status_pembayaran' => $b['pay_status'],
                'status_sesi'       => $b['sesi_status'],
                'waktu_mulai_sesi'  => $waktuMulai,
                'created_at'        => $date,
                'updated_at'        => $date,
            ]);

            $bookingModels[] = $booking;

            // Pembayaran
            $metodeList = ['Transfer Bank', 'QRIS', 'Paymenku'];
            $metode = $metodeList[array_rand($metodeList)];
            
            Pembayaran::create([
                'booking_id'               => $booking->id,
                'jumlah_bayar'             => $dokter->harga_sesi,
                'metode_pembayaran'        => $metode,
                'bukti_transfer'           => $b['pay_status'] === 'lunas' ? 'bukti_sample.jpg' : null,
                'paymentku_reference'      => 'booking-' . $booking->id,
                'paymentku_status'         => $b['pay_status'] === 'lunas' ? 'paid' : ($b['pay_status'] === 'pending' ? 'pending' : 'failed'),
                'verifikasi_oleh_admin_id' => $b['pay_status'] === 'lunas' ? $admin->id : null,
                'created_at'               => $date,
                'updated_at'               => $date,
            ]);
        }

        // 5. Antrean Offline (20 records, 6 for today)
        $tujuanList = [
            'Konsultasi Demam & Flu',
            'Pemeriksaan Gigi Rutin & Pembersihan Karang',
            'Konsultasi Lambung & Hipertensi',
            'Imunisasi Balita',
            'Pemeriksaan Telinga & Gangguan Pendengaran',
            'Cek Darah dan Kontrol Penyakit Dalam',
            'Pemeriksaan Gigi Berlubang',
            'Konsultasi Alergi Anak',
            'Cek Kesehatan Umum Harian',
            'Pemeriksaan Tenggorokan & Batuk Kronis',
        ];

        for ($i = 0; $i < 20; $i++) {
            $pasien = $pasienUsers[$i % count($pasienUsers)];
            $dokter = $dokterModels[$i % count($dokterModels)];

            // 6 antrean untuk hari ini, sisanya tersebar di hari-hari sebelumnya
            $isToday = $i < 6;
            $tglKunjungan = $isToday ? Carbon::today() : Carbon::today()->subDays(rand(1, 45));
            $status = $isToday ? ($i == 0 ? 'dipanggil' : ($i < 3 ? 'menunggu' : 'selesai')) : 'selesai';

            $antrean = AntreanOffline::create([
                'pasien_id'         => $pasien->id,
                'dokter_id'         => $dokter->id,
                'nomor_antrean'     => ($i % 10) + 1,
                'tanggal_kunjungan' => $tglKunjungan->toDateString(),
                'tujuan_kunjungan'  => $tujuanList[$i % count($tujuanList)],
                'status'            => $status,
                'created_at'        => $tglKunjungan,
                'updated_at'        => $tglKunjungan,
            ]);

            // Rekam medis untuk antrean offline yang selesai
            if ($status === 'selesai') {
                RekamMedis::create([
                    'pasien_id'          => $pasien->id,
                    'dokter_id'          => $dokter->id,
                    'antrean_offline_id' => $antrean->id,
                    'tanggal_periksa'    => $tglKunjungan->toDateString(),
                    'keluhan'            => $antrean->tujuan_kunjungan,
                    'diagnosa'           => 'Diagnosa klinis berdasarkan gejala pasien saat kunjungan offline.',
                    'tindakan'           => 'Pemeriksaan fisik umum dan konsultasi medis.',
                    'resep_obat'         => 'Paracetamol 500mg (3x1), Vitamin C 500mg (1x1).',
                    'catatan'            => 'Istirahat cukup dan banyak minum air putih.',
                    'created_at'         => $tglKunjungan,
                    'updated_at'         => $tglKunjungan,
                ]);
            }
        }

        // 6. Rekam Medis & Review Dokter untuk Booking yang selesai
        $rekamData = [
            ['keluhan' => 'Demam tinggi 3 hari, pusing, lemas', 'diagnosa' => 'Febris ec ISPA', 'tindakan' => 'Konsultasi & Peresepan Obat', 'resep' => 'Paracetamol 500mg 3x1, Amoxicillin 500mg 3x1'],
            ['keluhan' => 'Nyeri gigi geraham kanan bawah', 'diagnosa' => 'Karies Dentis', 'tindakan' => 'Pembersihan Karang & Penambalan Sementara', 'resep' => 'Cataflam 50mg 2x1, Amoxicillin 500mg 3x1'],
            ['keluhan' => 'Lambung sering perih setelah makan pedas', 'diagnosa' => 'Gastritis Akut', 'tindakan' => 'Edukasi Pola Makan & Terapi Obat', 'resep' => 'Omeprazole 20mg 2x1, Sucralfate Syr 3x1 Cth'],
            ['keluhan' => 'Anak batuk pilek dan tidak mau makan', 'diagnosa' => 'Common Cold pada Anak', 'tindakan' => 'Konsultasi Nutrisi & Obat Anak', 'resep' => 'Mucopect Drops 3x0.5ml, Sanmol Syr 3x1 Cth'],
            ['keluhan' => 'Telinga kiri terasa tersumbat dan agak berdenging', 'diagnosa' => 'Serumen Prop Auris Sinistra', 'tindakan' => 'Irigasi Telinga & Pembersihan Cerumen', 'resep' => 'Tetes Telinga Otopain 3x2 tetes'],
        ];

        $reviewUlasan = [
            'Penjelasan dokter sangat jelas, sabar, dan ramah sekali!',
            'Pelayanan memuaskan, tempat bersih, dan penanganan obat tepat.',
            'Dokter sangat komunikatif dan memberikan solusi pengobatan yang praktis.',
            'Pemeriksaan sangat teliti, konsultasi berjalan nyaman.',
            'Respon dokter cepat, diagnosis akurat, gejala langsung mereda.',
        ];

        foreach ($bookingModels as $idx => $b) {
            if ($b->status_sesi === 'selesai') {
                $rk = $rekamData[$idx % count($rekamData)];

                RekamMedis::create([
                    'pasien_id'       => $b->pasien_id,
                    'dokter_id'       => $b->dokter_id,
                    'booking_id'      => $b->id,
                    'tanggal_periksa' => $b->tanggal_booking,
                    'keluhan'         => $rk['keluhan'],
                    'diagnosa'        => $rk['diagnosa'],
                    'tindakan'        => $rk['tindakan'],
                    'resep_obat'      => $rk['resep'],
                    'catatan'         => 'Kontrol ulang dalam 5 hari jika gejala belum mereda.',
                    'created_at'      => $b->created_at,
                    'updated_at'      => $b->updated_at,
                ]);

                // Review Dokter
                ReviewDokter::create([
                    'booking_id'        => $b->id,
                    'pasien_id'         => $b->pasien_id,
                    'dokter_id'         => $b->dokter_id,
                    'rating_pelayanan'  => rand(4, 5),
                    'rating_komunikasi' => rand(4, 5),
                    'ulasan'            => $reviewUlasan[$idx % count($reviewUlasan)],
                    'created_at'        => $b->created_at,
                    'updated_at'        => $b->updated_at,
                ]);
            }
        }

        // 7. Survei Kepuasan Pasien (20 Survei)
        $saranList = [
            'Fasilitas sangat bersih, ruang tunggu nyaman dan adem.',
            'Proses pendaftaran online sangat mudah dan cepat!',
            'Pelayanan staf administrasi sangat ramah dan membantu.',
            'Secara keseluruhan sangat puas, pertahankan kualitasnya.',
            'Semoga kuota pendaftaran harian bisa ditambah.',
            'Klinik sangat direkomendasikan untuk keluarga.',
        ];

        foreach ($pasienUsers as $idx => $p) {
            SurveiKepuasan::create([
                'pasien_id'            => $p->id,
                'rating_pendaftaran'   => rand(4, 5),
                'rating_fasilitas'     => rand(3, 5),
                'rating_pelayanan_staf' => rand(4, 5),
                'rating_kebersihan'    => rand(4, 5),
                'rekomendasi_nps'      => rand(8, 10),
                'saran_masukan'        => $saranList[$idx % count($saranList)],
                'created_at'           => $p->created_at,
                'updated_at'           => $p->created_at,
            ]);
        }

        // 8. Chat Samples (untuk booking aktif/selesai)
        $aktifBooking = Booking::whereIn('status_sesi', ['aktif', 'selesai'])->first();
        if ($aktifBooking) {
            Chat::create([
                'booking_id'  => $aktifBooking->id,
                'pengirim_id' => $aktifBooking->pasien_id,
                'penerima_id' => $aktifBooking->dokter->user_id,
                'pesan'       => 'Halo Dokter, selamat siang. Sesi konsultasi sudah bisa dimulai?',
                'created_at'  => Carbon::now()->subMinutes(15),
            ]);
            Chat::create([
                'booking_id'  => $aktifBooking->id,
                'pengirim_id' => $aktifBooking->dokter->user_id,
                'penerima_id' => $aktifBooking->pasien_id,
                'pesan'       => 'Selamat siang. Iya betul, silakan sampaikan keluhan yang dirasakan saat ini.',
                'created_at'  => Carbon::now()->subMinutes(10),
            ]);
        }
    }
}

