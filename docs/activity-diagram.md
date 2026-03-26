# 🔄 Activity Diagram — Sistem Manajemen Klinik Pratama Orinda

## Deskripsi

Activity Diagram menggambarkan alur aktivitas atau proses bisnis utama dalam sistem. Setiap diagram menunjukkan urutan langkah dari satu titik awal hingga akhir untuk satu skenario.

---

## AD-01: Alur Booking Online + Pembayaran

```
[Mulai]
   │
   ▼
Pasien Login
   │
   ▼
Pilih Dokter & Jadwal
   │
   ▼
Sistem Cek Slot Tersedia?
   ├── TIDAK → Tampil notif "Slot Penuh" → Kembali Pilih Jadwal
   └── YA ──▼
Konfirmasi Data Booking
   │
   ▼
Klik "Bayar Sekarang"
   │
   ▼
Midtrans Snap Popup Terbuka
   │
   ▼
Pasien Pilih Metode Pembayaran
   │
   ▼
Proses Pembayaran di Gateway
   │
   ▼
Status Pembayaran?
   ├── GAGAL → Tampil notif gagal → Kembali ke halaman booking
   └── SUKSES ──▼
Webhook Midtrans Update Status DB
   │
   ▼
Booking Status = "confirmed"
   │
   ▼
Tampil Konfirmasi & Nomor Antrian
   │
   ▼
[Selesai]
```

---

## AD-02: Alur Walk-in / Antrean Offline

```
[Mulai]
   │
   ▼
Pasien Login
   │
   ▼
Buka Halaman Antrean Walk-in
   │
   ▼
Sistem Generate Nomor Antrian
   │
   ▼
Tampil Nomor & Estimasi Waktu
   │
   ▼
Pasien Menunggu Panggilan
   │
   ▼
Dokter Update Status Sesi = "selesai"
   │
   ▼
[Selesai]
```

---

## AD-03: Alur Konsultasi Dokter

```
[Mulai]
   │
   ▼
Dokter Login
   │
   ▼
Lihat Dashboard Pasien Harian
   │
   ▼
Ada Pasien Masuk?
   ├── TIDAK → Tunggu / Refresh
   └── YA ──▼
Buka Data Pasien (Riwayat & Info)
   │
   ▼
Lakukan Konsultasi
   │
   ▼
Chat Real-time atau Tatap Muka
   │
   ▼
Update Status Sesi = "selesai"
   │
   ▼
[Selesai]
```

---

## AD-04: Alur SPK SAW (Admin)

```
[Mulai]
   │
   ▼
Admin Login
   │
   ▼
Buka Halaman SPK Dokter
   │
   ▼
Sistem Ambil Data Review Pasien dari DB
   │
   ▼
Normalisasi Nilai per Kriteria
   │
   ▼
Hitung Bobot SAW
   │
   ▼
Hitung Total Nilai Akhir per Dokter
   │
   ▼
Urutkan Ranking Dokter (Tertinggi → Terendah)
   │
   ▼
Tampil Tabel Ranking
   │
   ▼
[Selesai]
```

---

## AD-05: Alur Login & Autentikasi

```
[Mulai]
   │
   ▼
Pengguna Buka Halaman Login
   │
   ▼
Masukkan Username & Password
   │
   ▼
Submit Form
   │
   ▼
Sistem Validasi Kredensial
   ├── SALAH → Tampil error "Kredensial tidak valid" → Kembali ke Form Login
   └── BENAR ──▼
Sistem Identifikasi Role
   ├── Admin → Redirect ke /admin/dashboard
   ├── Dokter → Redirect ke /dokter/dashboard
   └── Pasien → Redirect ke /pasien/dashboard
   │
   ▼
Session Dibuat dengan Anti-Cache Header
   │
   ▼
[Selesai]
```

---

## Keterangan Simbol

| Simbol | Makna |
|---|---|
| `[Mulai] / [Selesai]` | Start / End state |
| `──▼` | Alur maju / transisi |
| `├──` | Kondisi percabangan |
| Kotak teks | Aktivitas / Action |
