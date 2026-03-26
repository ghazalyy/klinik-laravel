# 📌 Use Case Diagram — Sistem Manajemen Klinik Pratama Orinda

## Deskripsi

Use Case Diagram menggambarkan interaksi antara **aktor** (pengguna sistem) dengan **use case** (fungsionalitas) yang tersedia dalam sistem. Diagram ini memperlihatkan siapa saja yang menggunakan sistem dan apa saja yang dapat mereka lakukan.

---

## Aktor

| Aktor | Deskripsi |
|---|---|
| **Admin** | Pengelola utama sistem, memiliki akses penuh ke semua fitur manajemen |
| **Dokter** | Tenaga medis yang menangani pasien, akses ke jadwal & rekam medis |
| **Pasien** | Pengguna akhir yang melakukan booking dan pembayaran |
| **Sistem (Midtrans)** | Aktor eksternal untuk pemrosesan pembayaran otomatis |

---

## Use Case Diagram (Teks)

```
+--------------------------------------------------+
|         Sistem Manajemen Klinik Pratama Orinda   |
|                                                  |
|  [Admin]                                         |
|    ├── UC-01: Login                              |
|    ├── UC-02: Kelola Pengguna (View Only)        |
|    ├── UC-03: Kelola Data Dokter                 |
|    ├── UC-04: Kelola Jadwal Praktik              |
|    ├── UC-05: Kelola Data Booking                |
|    ├── UC-06: Lihat CRM & Analitik               |
|    ├── UC-07: Hitung SPK SAW Dokter              |
|    └── UC-08: Unduh Laporan CSV                  |
|                                                  |
|  [Dokter]                                        |
|    ├── UC-01: Login                              |
|    ├── UC-09: Lihat Dashboard Pasien Harian      |
|    ├── UC-10: Update Status Sesi Konsultasi      |
|    ├── UC-11: Lihat Riwayat Konsultasi           |
|    └── UC-12: Chat Real-time dengan Pasien       |
|                                                  |
|  [Pasien]                                        |
|    ├── UC-01: Login / Register                   |
|    ├── UC-13: Booking Jadwal Online              |
|    ├── UC-14: Ambil Antrean Walk-in              |
|    ├── UC-15: Pembayaran via Midtrans Snap       |
|    ├── UC-16: Lihat Riwayat Booking              |
|    ├── UC-17: Beri Review & Rating Dokter        |
|    ├── UC-18: Chat Real-time dengan Dokter       |
|    └── UC-19: Download Riwayat Chat (.txt)       |
|                                                  |
|  [Sistem Midtrans] ── UC-15: Verifikasi Bayar   |
+--------------------------------------------------+
```

---

## Detail Use Case

### UC-01: Login
| | |
|---|---|
| **Aktor** | Admin, Dokter, Pasien |
| **Deskripsi** | Pengguna masuk ke sistem menggunakan username dan password |
| **Prasyarat** | Akun sudah terdaftar di database |
| **Alur Utama** | 1. Buka halaman login → 2. Masukkan kredensial → 3. Sistem validasi → 4. Redirect ke dashboard sesuai role |
| **Alur Alternatif** | Kredensial salah → tampil pesan error, kembali ke form login |

### UC-13: Booking Jadwal Online
| | |
|---|---|
| **Aktor** | Pasien |
| **Deskripsi** | Pasien memilih dokter, tanggal, dan jam praktik untuk reservasi |
| **Prasyarat** | Pasien sudah login |
| **Alur Utama** | 1. Pilih dokter → 2. Pilih jadwal tersedia → 3. Konfirmasi booking → 4. Lanjut ke pembayaran |
| **Include** | UC-15: Pembayaran via Midtrans Snap |

### UC-15: Pembayaran via Midtrans Snap
| | |
|---|---|
| **Aktor** | Pasien, Sistem Midtrans |
| **Deskripsi** | Proses pembayaran otomatis menggunakan Midtrans Snap API |
| **Prasyarat** | Booking berhasil dibuat |
| **Alur Utama** | 1. Pasien klik bayar → 2. Midtrans Snap popup terbuka → 3. Pasien pilih metode bayar → 4. Webhook update status |

### UC-07: Hitung SPK SAW Dokter
| | |
|---|---|
| **Aktor** | Admin |
| **Deskripsi** | Sistem menghitung dan meranking dokter berdasarkan kriteria SAW (Simple Additive Weighting) dari data review pasien |
| **Prasyarat** | Ada data review pasien di database |
| **Alur Utama** | 1. Admin buka halaman SPK → 2. Sistem kalkulasi nilai SAW → 3. Tampil ranking dokter |

---

## Relasi Use Case

| Relasi | Use Case |
|---|---|
| `<<include>>` | UC-13 *include* UC-15 |
| `<<extend>>` | UC-15 *extend* UC-13 (jika booking selesai) |
| `<<generalization>>` | UC-01 (Login) berlaku untuk semua aktor |
