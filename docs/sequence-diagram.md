# 📊 Sequence Diagram — Sistem Manajemen Klinik Pratama Orinda

## Deskripsi

Sequence Diagram menggambarkan urutan interaksi antar objek dalam sistem untuk menyelesaikan sebuah skenario/use case. Diagram dibaca dari atas ke bawah, menunjukkan pesan yang dikirim antar komponen.

---

## SD-01: Proses Login

```
Pasien/Dokter/Admin    Browser    LoginController    AuthService    DB
       │                 │               │                │          │
       │── Buka /login──►│               │                │          │
       │                 │── GET login ─►│                │          │
       │                 │◄── tampil form│                │          │
       │── Isi & submit ►│               │                │          │
       │                 │── POST login ►│                │          │
       │                 │               │── cek user ───►│          │
       │                 │               │               │── SELECT ►│
       │                 │               │               │◄── data ──│
       │                 │               │◄── user found ─│          │
       │                 │               │                │          │
       │                 │               │ (validasi password)       │
       │                 │               │                │          │
       │                 │◄── redirect dashboard (sesuai role) ──────│
       │◄── dashboard ───│               │                │          │
```

---

## SD-02: Booking Online + Pembayaran Midtrans

```
Pasien    Browser    BookingController    MidtransService    Midtrans API    WebhookController    DB
  │          │              │                   │                │                  │              │
  │─ pilih dokter & jadwal ►│                   │                │                  │              │
  │          │─ POST booking►│                  │                │                  │              │
  │          │              │─ simpan booking ─────────────────────────────────────────────────►│
  │          │              │◄─ booking saved ─────────────────────────────────────────────────│
  │          │              │                   │                │                  │              │
  │          │              │─ buat snap token ►│                │                  │              │
  │          │              │                   │─ POST /snap ──►│                  │              │
  │          │              │                   │◄── snap_token ─│                  │              │
  │          │◄─ snap_token ─│                  │                │                  │              │
  │          │              │                   │                │                  │              │
  │── klik "Bayar" ─────────►│                  │                │                  │              │
  │          │── Midtrans Snap.pay(token) ──────────────────────►│                  │              │
  │◄─ popup Snap terbuka ───│                   │                │                  │              │
  │── pilih metode & bayar ─────────────────────────────────────►│                  │              │
  │          │              │                   │                │                  │              │
  │          │              │                   │ (Midtrans proses pembayaran)      │              │
  │          │              │                   │                │                  │              │
  │          │              │                   │                │─ POST webhook ──►│              │
  │          │              │                   │                │                  │─ update DB ─►│
  │          │              │                   │                │                  │◄─ updated ───│
  │◄─ notif booking confirmed ───────────────────────────────────────────────────────────────────│
```

---

## SD-03: Chat Real-time (Polling)

```
Pasien    Browser    JavaScript (Polling)    ChatController    DB
  │          │                │                    │            │
  │─ buka halaman chat ──────►│                    │            │
  │          │─ GET /chat/init►│                   │            │
  │          │                │─ GET pesan ───────►│            │
  │          │                │                    │─ SELECT ──►│
  │          │                │                    │◄─ messages ─│
  │          │◄── render chat ─│                   │            │
  │          │                │                    │            │
  │── tulis pesan ───────────►│                    │            │
  │          │─ POST /chat/send►│                  │            │
  │          │                │─ simpan pesan ────►│            │
  │          │                │                    │─ INSERT ──►│
  │          │                │                    │◄─ saved ───│
  │          │◄─ 200 OK ────────│                  │            │
  │          │                │                    │            │
  │          │ (setiap 3 detik polling)             │            │
  │          │─ GET /chat/messages ──────────────►│            │
  │          │                │                    │─ SELECT ──►│
  │          │◄─ pesan baru ───│                   │◄─ data ────│
  │◄─ tampil pesan baru ──────│                    │            │
```

---

## SD-04: Kalkulasi SPK SAW (Admin)

```
Admin    Browser    SpkController    Review Model    Dokter Model    DB
  │          │             │               │               │          │
  │─ buka /admin/spk ─────►│              │               │          │
  │          │─ GET spk ──►│              │               │          │
  │          │             │─ ambil semua dokter ────────►│          │
  │          │             │                              │─ SELECT ─►│
  │          │             │◄──────────── data dokters ───│          │
  │          │             │─ ambil reviews per dokter ──►│          │
  │          │             │               │─ SELECT reviews ────────►│
  │          │             │◄── reviews ───│               │          │
  │          │             │               │               │          │
  │          │             │ (hitung nilai SAW per kriteria)          │
  │          │             │ (normalisasi matriks)                    │
  │          │             │ (kalkulasi nilai akhir)                  │
  │          │             │ (urutkan ranking)                        │
  │          │             │               │               │          │
  │          │◄─ tampil tabel ranking ─────│               │          │
  │◄─ hasil SPK ─────────────────────────────────────────────────────│
```

---

## SD-05: Midtrans Webhook Handler

```
Midtrans    WebhookController    PembayaranModel    BookingModel    DB
    │               │                  │                 │           │
    │─ POST /webhook►│                 │                 │           │
    │               │─ verifikasi signature Midtrans     │           │
    │               │─ ambil order_id dari payload       │           │
    │               │─ cari pembayaran ─────────────────►│           │
    │               │                  │─ SELECT ───────────────────►│
    │               │                  │◄─ pembayaran ──────────────│
    │               │                  │                 │           │
    │               │ (cek transaction_status)           │           │
    │               │                  │                 │           │
    │               │ [jika "settlement"]:               │           │
    │               │─ update status = "paid" ──────────►│           │
    │               │                  │─ UPDATE ───────────────────►│
    │               │─ update booking = "confirmed" ─────────────────►│
    │               │                  │                 │─ UPDATE ──►│
    │               │                  │                 │           │
    │◄─ 200 OK ───────│                │                 │           │
```

---

## Legenda

| Simbol | Makna |
|---|---|
| `─►` | Pesan/request dikirim |
| `◄─` | Response diterima |
| `│` | Lifeline (timeline objek aktif) |
| teks dalam `()` | Proses internal, tidak melibatkan komponen lain |
| `[jika ...]` | Percabangan kondisi |
