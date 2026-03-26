# 📚 Daftar Isi Skripsi — Sistem Informasi Manajemen Klinik Pratama Orinda

> **Catatan:** Dokumen ini berisi panduan daftar isi dan poin-poin yang harus diisi untuk Bab 1, 2, dan 3 skripsi berbasis proyek klinik-laravel ini.

---

## 📄 Halaman Awal (Prahalaman)

- Halaman Judul
- Halaman Persetujuan Pembimbing
- Halaman Pengesahan Penguji
- Pernyataan Keaslian Skripsi
- Halaman Motto & Persembahan *(opsional)*
- Kata Pengantar
- Abstrak (Bahasa Indonesia)
- Abstract (Bahasa Inggris)
- **Daftar Isi**
- Daftar Tabel
- Daftar Gambar
- Daftar Lampiran *(jika ada)*

---

## BAB I — PENDAHULUAN

### 1.1 Latar Belakang
- Jelaskan kondisi nyata klinik yang masih menggunakan sistem manual (pencatatan pasien, booking, antrian)
- Uraikan masalah yang muncul akibat sistem manual (antrian menumpuk, data hilang, pembayaran tidak tercatat)
- Perkenalkan solusi: **Sistem Informasi Manajemen Klinik berbasis Web** menggunakan Laravel 12
- Sebutkan fitur unggulan: booking online, Midtrans payment, SPK SAW, CRM, chat real-time
- Tutup dengan pentingnya sistem ini bagi operasional klinik

### 1.2 Rumusan Masalah
Contoh rumusan masalah:
1. Bagaimana merancang dan membangun sistem informasi manajemen klinik berbasis web yang dapat mengelola booking online, pembayaran, dan data pasien secara terintegrasi?
2. Bagaimana mengimplementasikan sistem pendukung keputusan (SPK) metode SAW untuk meranking dokter berdasarkan ulasan pasien?
3. Bagaimana mengintegrasikan payment gateway Midtrans Snap ke dalam sistem pembayaran klinik?

### 1.3 Tujuan Penelitian
1. Merancang dan membangun sistem informasi manajemen klinik berbasis Laravel 12 yang mencakup fitur booking online, manajemen dokter, dan rekam medis digital
2. Mengimplementasikan metode SAW pada modul SPK untuk menghasilkan ranking dokter secara objektif
3. Mengintegrasikan Midtrans Snap API sebagai solusi pembayaran otomatis yang aman dan efisien

### 1.4 Manfaat Penelitian

**Manfaat Teoritis:**
- Menjadi referensi implementasi framework Laravel 12 pada sistem informasi kesehatan
- Memperkaya kajian penerapan metode SPK SAW pada domain manajemen pelayanan medis

**Manfaat Praktis:**
- Bagi Klinik: mempercepat proses administrasi, mengurangi antrian manual, dan meningkatkan akurasi data
- Bagi Pasien: kemudahan booking dan pembayaran dari mana saja
- Bagi Dokter: monitoring jadwal dan riwayat pasien yang lebih terstruktur

### 1.5 Batasan Masalah
1. Sistem dibangun menggunakan framework Laravel 12 dan database MySQL
2. Payment gateway yang digunakan adalah Midtrans Snap (Sandbox & Production)
3. Metode SPK yang digunakan adalah **Simple Additive Weighting (SAW)**
4. Sistem hanya mengelola tiga role: Admin, Dokter, dan Pasien
5. Fitur chat hanya mendukung komunikasi antara Dokter dan Pasien (asinkronus/polling)
6. Sistem tidak mencakup modul rekam medis berbasis SOAP atau HL7

### 1.6 Sistematika Penulisan
Jelaskan secara singkat isi setiap bab:
- **BAB I:** Pendahuluan — latar belakang, rumusan, tujuan, manfaat, batasan
- **BAB II:** Tinjauan Pustaka — dasar teori dan penelitian terdahulu
- **BAB III:** Metodologi Penelitian — metode pengembangan, analisis kebutuhan, perancangan sistem
- **BAB IV:** Implementasi & Pengujian — hasil pembangunan sistem dan hasil uji
- **BAB V:** Penutup — kesimpulan dan saran

---

## BAB II — TINJAUAN PUSTAKA

### 2.1 Penelitian Terdahulu
> Buat tabel minimal 5 penelitian relevan dengan kolom: No, Penulis (Tahun), Judul, Metode/Tools, Kelebihan, Kekurangan

Tema yang relevan untuk dicari:
- Sistem informasi klinik / puskesmas berbasis web
- Implementasi SPK SAW pada layanan kesehatan
- Integrasi payment gateway pada sistem e-commerce / kesehatan
- Sistem booking online real-time

### 2.2 Landasan Teori

#### 2.2.1 Sistem Informasi
- Definisi sistem informasi (menurut 2–3 ahli)
- Komponen sistem informasi

#### 2.2.2 Klinik Pratama
- Definisi klinik pratama berdasarkan Permenkes
- Alur pelayanan klinik

#### 2.2.3 Framework Laravel
- Sejarah singkat Laravel
- Konsep MVC (Model-View-Controller) pada Laravel
- Fitur unggulan Laravel 12: Eloquent ORM, Middleware, Artisan, Migration, Seeder

#### 2.2.4 Metode SAW (Simple Additive Weighting)
- Definisi dan konsep SPK
- Rumus SAW:
  - Normalisasi: `r_ij = x_ij / max(x_ij)` (benefit) atau `min(x_ij) / x_ij` (cost)
  - Nilai akhir: `V_i = Σ (w_j × r_ij)`
- Langkah-langkah perhitungan SAW
- Kriteria yang digunakan (rating, jumlah ulasan, ketepatan waktu, dll)

#### 2.2.5 Payment Gateway — Midtrans
- Definisi payment gateway
- Cara kerja Midtrans Snap API
- Alur transaksi: Request Token → Snap Popup → Webhook Notifikasi

#### 2.2.6 Entity Relationship Diagram (ERD)
- Definisi ERD
- Komponen ERD: entitas, atribut, relasi, kardinalitas

#### 2.2.7 Unified Modeling Language (UML)
- Use Case Diagram
- Activity Diagram
- Class Diagram
- Sequence Diagram

#### 2.2.8 MySQL / MariaDB
- Definisi basis data relasional
- Keunggulan MySQL pada aplikasi web

#### 2.2.9 XAMPP
- Definisi dan fungsi XAMPP sebagai local server development

---

## BAB III — METODOLOGI PENELITIAN

### 3.1 Metode Penelitian
- Jelaskan jenis penelitian: **penelitian terapan** / *applied research*
- Metode pengembangan sistem yang digunakan: **Waterfall** (atau sesuaikan dengan yang dipakai)

```
Waterfall:
Analisis Kebutuhan → Desain Sistem → Implementasi → Pengujian → Pemeliharaan
```

> Jika menggunakan metode lain seperti Agile/Scrum atau Prototype, jelaskan tahapannya di sini.

### 3.2 Analisis Kebutuhan Sistem

#### 3.2.1 Kebutuhan Fungsional
| No | Kebutuhan | Aktor |
|---|---|---|
| KF-01 | Sistem dapat melakukan autentikasi login dengan role-based access | Admin, Dokter, Pasien |
| KF-02 | Sistem dapat mengelola data dokter dan jadwal praktik | Admin |
| KF-03 | Pasien dapat melakukan booking online dan walk-in | Pasien |
| KF-04 | Sistem mengintegrasikan Midtrans Snap untuk pembayaran | Pasien |
| KF-05 | Sistem menghitung ranking dokter dengan metode SAW | Admin |
| KF-06 | Pasien dan dokter dapat berkomunikasi via chat real-time | Pasien, Dokter |
| KF-07 | Admin dapat mengunduh laporan data dalam format CSV | Admin |
| KF-08 | Pasien dapat memberikan review dan rating dokter | Pasien |

#### 3.2.2 Kebutuhan Non-Fungsional
| No | Kebutuhan |
|---|---|
| KNF-01 | Sistem menggunakan HTTPS dan proteksi CSRF |
| KNF-02 | Halaman tidak dapat diakses setelah logout (anti-cache) |
| KNF-03 | Antarmuka responsif (mobile-friendly) |
| KNF-04 | Response time halaman < 3 detik pada koneksi normal |
| KNF-05 | Sistem harus berjalan pada PHP 8.2+ dan MySQL 5.7+ |

### 3.3 Perancangan Sistem

#### 3.3.1 Use Case Diagram
> Sertakan gambar Use Case Diagram
> (Lihat detail: [docs/usecase.md](usecase.md))

#### 3.3.2 Activity Diagram
> Sertakan gambar Activity Diagram untuk proses utama:
> - Alur Login
> - Alur Booking + Pembayaran
> - Alur Konsultasi Dokter
> - Alur SPK SAW
>
> (Lihat detail: [docs/activity-diagram.md](activity-diagram.md))

#### 3.3.3 Sequence Diagram
> Sertakan gambar Sequence Diagram untuk skenario utama
> (Lihat detail: [docs/sequence-diagram.md](sequence-diagram.md))

#### 3.3.4 Class Diagram
> Sertakan gambar Class Diagram beserta relasi antar Model Eloquent dan Controller
> (Lihat detail: [docs/class-diagram.md](class-diagram.md))

### 3.4 Perancangan Database

#### 3.4.1 Entity Relationship Diagram (ERD)
> Sertakan gambar ERD
> (Lihat detail: [docs/erd.md](erd.md))

#### 3.4.2 Deskripsi Tabel
> Buat tabel deskripsi untuk setiap tabel database:
> `users`, `dokters`, `jadwal_dokters`, `bookings`, `pembayarans`, `reviews`, `chat_messages`
>
> Setiap tabel dicantumkan: nama kolom, tipe data, constraint, dan keterangan

### 3.5 Perancangan Antarmuka (Wireframe / Mockup)
> Sertakan gambar wireframe atau mockup dari halaman:
> - Halaman Login
> - Dashboard Admin
> - Halaman Booking Pasien
> - Halaman Pembayaran (Midtrans Snap)
> - Halaman SPK Dokter
> - Halaman Chat

### 3.6 Spesifikasi Perangkat
#### 3.6.1 Perangkat Keras (Hardware)
| Komponen | Spesifikasi |
|---|---|
| Processor | Minimal Intel Core i3 / AMD Ryzen 3 |
| RAM | Minimal 4 GB |
| Storage | Minimal 20 GB tersedia |

#### 3.6.2 Perangkat Lunak (Software)
| Komponen | Versi |
|---|---|
| OS | Windows 10/11 / Ubuntu 20.04+ |
| PHP | 8.2 atau lebih baru |
| Laravel | 12 (Stable) |
| MySQL | 5.7 / MariaDB 10.4+ |
| XAMPP | 8.2.x |
| Composer | 2.x |
| Browser | Google Chrome / Firefox (terbaru) |

---

## 📌 Tips Penulisan

> [!TIP]
> - Setiap bab harus diawali dengan **pengantar singkat** (1–2 paragraf) yang menjelaskan isi bab
> - Setiap gambar (diagram, mockup, screenshot) harus diberi **nomor dan keterangan** (caption)
> - Setiap tabel harus diberi **judul tabel** di atasnya
> - Kutipan teori wajib mencantumkan **sumber (nama, tahun, halaman)**
> - Gunakan **Mendeley / Zotero** untuk manajemen referensi dan daftar pustaka otomatis
> - Format sitasi yang umum digunakan: **APA 7th Edition**

> [!IMPORTANT]
> Bab IV (Implementasi & Pengujian) dan Bab V (Penutup/Kesimpulan) tidak tercakup di dokumen ini. Buat catatan terpisah jika diperlukan.
