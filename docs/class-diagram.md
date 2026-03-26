# 🧩 Class Diagram — Sistem Manajemen Klinik Pratama Orinda

## Deskripsi

Class Diagram menggambarkan struktur kelas dalam aplikasi Laravel, termasuk Model Eloquent, atributnya, method-method penting, dan relasi antar model.

---

## Model & Relasi

### Model: `User`
```
+-----------------------------+
|           User              |
+-----------------------------+
| - id: int                   |
| - name: string              |
| - username: string          |
| - email: string             |
| - password: string          |
| - role: string              |
+-----------------------------+
| + dokter(): HasOne          |
| + bookings(): HasMany       |
| + reviews(): HasMany        |
| + sentMessages(): HasMany   |
| + receivedMessages(): HasMany|
| + isAdmin(): bool           |
| + isDokter(): bool          |
| + isPasien(): bool          |
+-----------------------------+
```

---

### Model: `Dokter`
```
+-----------------------------+
|           Dokter            |
+-----------------------------+
| - id: int                   |
| - user_id: int (FK)         |
| - nama: string              |
| - spesialis: string         |
| - foto: string              |
| - no_hp: string             |
+-----------------------------+
| + user(): BelongsTo         |
| + jadwals(): HasMany        |
| + bookings(): HasMany       |
| + reviews(): HasMany        |
| + avgRating(): float        |
| + getRatingAttribute(): float|
+-----------------------------+
```

---

### Model: `JadwalDokter`
```
+-----------------------------+
|        JadwalDokter         |
+-----------------------------+
| - id: int                   |
| - dokter_id: int (FK)       |
| - hari: string              |
| - jam_mulai: time           |
| - jam_selesai: time         |
| - kuota: int                |
+-----------------------------+
| + dokter(): BelongsTo       |
| + bookings(): HasMany       |
| + sisaKuota(): int          |
+-----------------------------+
```

---

### Model: `Booking`
```
+-----------------------------+
|           Booking           |
+-----------------------------+
| - id: int                   |
| - pasien_id: int (FK)       |
| - dokter_id: int (FK)       |
| - jadwal_id: int (FK)       |
| - tanggal: date             |
| - no_antrian: int           |
| - status: string            |
| - tipe: string              |
+-----------------------------+
| + pasien(): BelongsTo       |
| + dokter(): BelongsTo       |
| + jadwal(): BelongsTo       |
| + pembayaran(): HasOne      |
| + review(): HasOne          |
| + chatMessages(): HasMany   |
| + isConfirmed(): bool       |
| + isPending(): bool         |
+-----------------------------+
```

---

### Model: `Pembayaran`
```
+-----------------------------+
|         Pembayaran          |
+-----------------------------+
| - id: int                   |
| - booking_id: int (FK)      |
| - order_id: string          |
| - amount: decimal           |
| - status: string            |
| - payment_type: string      |
| - snap_token: text          |
| - paid_at: timestamp        |
+-----------------------------+
| + booking(): BelongsTo      |
| + isPaid(): bool            |
| + isFailed(): bool          |
| + isExpired(): bool         |
+-----------------------------+
```

---

### Model: `Review`
```
+-----------------------------+
|           Review            |
+-----------------------------+
| - id: int                   |
| - pasien_id: int (FK)       |
| - dokter_id: int (FK)       |
| - booking_id: int (FK)      |
| - rating: int               |
| - komentar: text            |
+-----------------------------+
| + pasien(): BelongsTo       |
| + dokter(): BelongsTo       |
| + booking(): BelongsTo      |
+-----------------------------+
```

---

### Model: `ChatMessage`
```
+-----------------------------+
|         ChatMessage         |
+-----------------------------+
| - id: int                   |
| - sender_id: int (FK)       |
| - receiver_id: int (FK)     |
| - booking_id: int (FK)      |
| - pesan: text               |
+-----------------------------+
| + sender(): BelongsTo       |
| + receiver(): BelongsTo     |
| + booking(): BelongsTo      |
+-----------------------------+
```

---

## Controller (Layer Kontrol)

| Controller | Tanggung Jawab |
|---|---|
| `LoginController` | Autentikasi, session, logout |
| `Admin\DokterController` | CRUD data dokter |
| `Admin\JadwalController` | CRUD jadwal praktik |
| `Admin\BookingController` | Monitoring semua booking |
| `Admin\SpkController` | Kalkulasi SPK SAW |
| `Admin\CrmController` | Analitik & statistik |
| `Pasien\BookingController` | Booking & walk-in |
| `Pasien\PembayaranController` | Integrasi Midtrans Snap |
| `Pasien\ReviewController` | Submit review dokter |
| `ChatController` | Real-time chat API |
| `MidtransWebhookController` | Handle notifikasi Midtrans |

---

## Middleware

| Middleware | Fungsi |
|---|---|
| `CheckRole` | Verifikasi role akses route |
| `NoCache` | Set header anti-cache pasca-logout |

---

## Relasi Antar Model (Summary)

```
User ─── HasOne ──────► Dokter
User ─── HasMany ─────► Booking (sebagai pasien)
User ─── HasMany ─────► Review (sebagai pasien)
User ─── HasMany ─────► ChatMessage (sender & receiver)

Dokter ── HasMany ────► JadwalDokter
Dokter ── HasMany ────► Booking
Dokter ── HasMany ────► Review

JadwalDokter ── HasMany ► Booking

Booking ── HasOne ────► Pembayaran
Booking ── HasOne ────► Review
Booking ── HasMany ───► ChatMessage
```
