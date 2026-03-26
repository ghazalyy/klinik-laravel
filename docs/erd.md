# 🗄️ ERD — Entity Relationship Diagram

## Deskripsi

Entity Relationship Diagram (ERD) menggambarkan struktur database sistem, entitas yang ada, atribut-atributnya, dan relasi antar entitas.

---

## Daftar Entitas & Atribut

### 1. `users`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | INT (PK) | Primary Key |
| `name` | VARCHAR(100) | Nama lengkap |
| `username` | VARCHAR(50) | Username unik |
| `email` | VARCHAR(100) | Email unik |
| `password` | VARCHAR(255) | Password terenkripsi |
| `role` | ENUM | `admin`, `dokter`, `pasien` |
| `created_at` | TIMESTAMP | Waktu registrasi |
| `updated_at` | TIMESTAMP | Waktu update terakhir |

---

### 2. `dokters` (Profil Dokter)
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | INT (PK) | Primary Key |
| `user_id` | INT (FK) | Relasi ke `users.id` |
| `nama` | VARCHAR(100) | Nama dokter |
| `spesialis` | VARCHAR(100) | Spesialisasi/poli |
| `foto` | VARCHAR(255) | Path foto profil |
| `no_hp` | VARCHAR(20) | Nomor telepon |
| `created_at` | TIMESTAMP | |
| `updated_at` | TIMESTAMP | |

---

### 3. `jadwal_dokters` (Jadwal Praktik)
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | INT (PK) | Primary Key |
| `dokter_id` | INT (FK) | Relasi ke `dokters.id` |
| `hari` | ENUM | Senin–Minggu |
| `jam_mulai` | TIME | Jam mulai praktik |
| `jam_selesai` | TIME | Jam selesai praktik |
| `kuota` | INT | Maksimal pasien per sesi |

---

### 4. `bookings`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | INT (PK) | Primary Key |
| `pasien_id` | INT (FK) | Relasi ke `users.id` |
| `dokter_id` | INT (FK) | Relasi ke `dokters.id` |
| `jadwal_id` | INT (FK) | Relasi ke `jadwal_dokters.id` |
| `tanggal` | DATE | Tanggal booking |
| `no_antrian` | INT | Nomor antrian |
| `status` | ENUM | `pending`, `confirmed`, `selesai`, `batal` |
| `tipe` | ENUM | `online`, `walkin` |
| `created_at` | TIMESTAMP | |

---

### 5. `pembayarans` (Transaksi)
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | INT (PK) | Primary Key |
| `booking_id` | INT (FK) | Relasi ke `bookings.id` |
| `order_id` | VARCHAR(100) | ID unik order Midtrans |
| `amount` | DECIMAL(12,2) | Nominal pembayaran |
| `status` | ENUM | `pending`, `paid`, `failed`, `expired` |
| `payment_type` | VARCHAR(50) | QRIS/VA/E-Wallet/dll |
| `snap_token` | TEXT | Token Midtrans Snap |
| `paid_at` | TIMESTAMP | Waktu pembayaran sukses |

---

### 6. `reviews`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | INT (PK) | Primary Key |
| `pasien_id` | INT (FK) | Relasi ke `users.id` |
| `dokter_id` | INT (FK) | Relasi ke `dokters.id` |
| `booking_id` | INT (FK) | Relasi ke `bookings.id` |
| `rating` | TINYINT | Nilai 1–5 |
| `komentar` | TEXT | Ulasan pasien |
| `created_at` | TIMESTAMP | |

---

### 7. `chat_messages`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | INT (PK) | Primary Key |
| `sender_id` | INT (FK) | Relasi ke `users.id` |
| `receiver_id` | INT (FK) | Relasi ke `users.id` |
| `booking_id` | INT (FK) | Konteks konsultasi |
| `pesan` | TEXT | Isi pesan |
| `created_at` | TIMESTAMP | Waktu kirim |

---

## Relasi Antar Entitas

```
users (1) ──────────── (1) dokters
  │                         │
  │ (1)                     │ (1)
  │                         │
bookings (N) ────────── (N) jadwal_dokters
  │
  │ (1)
  │
pembayarans (1)

users (1) ────── reviews (N) ────── dokters (1)
users (1) ────── chat_messages (N) ────── users (1)
bookings (1) ─── chat_messages (N)
bookings (1) ─── reviews (1)
```

---

## Kardinalitas

| Relasi | Tipe |
|---|---|
| `users` → `dokters` | One-to-One (1:1) |
| `dokters` → `jadwal_dokters` | One-to-Many (1:N) |
| `users` (pasien) → `bookings` | One-to-Many (1:N) |
| `dokters` → `bookings` | One-to-Many (1:N) |
| `bookings` → `pembayarans` | One-to-One (1:1) |
| `dokters` → `reviews` | One-to-Many (1:N) |
| `users` (pasien) → `reviews` | One-to-Many (1:N) |
| `users` → `chat_messages` (sender) | One-to-Many (1:N) |
| `users` → `chat_messages` (receiver) | One-to-Many (1:N) |
