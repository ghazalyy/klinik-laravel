<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Dokter;
use App\Http\Controllers\Pasien;

// =============================================
// HALAMAN PUBLIK
// =============================================
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/jadwal', [PublicController::class, 'jadwal'])->name('jadwal');
Route::get('/tentang', [PublicController::class, 'tentang'])->name('tentang');

// =============================================
// AUTENTIKASI
// =============================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// =============================================
// PROFIL (semua role)
// =============================================
Route::middleware('auth')->group(function () {
    Route::get('/profil', [PublicController::class, 'profil'])->name('profil');
    Route::post('/profil', [PublicController::class, 'updateProfil'])->name('profil.update');
});

// =============================================
// PANEL ADMIN
// =============================================
Route::middleware(['auth', 'nocache', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // CRM
    Route::get('/crm', [Admin\CrmController::class, 'dashboard'])->name('crm.dashboard');
    Route::get('/crm/pasien/{id}', [Admin\CrmController::class, 'detailPasien'])->name('crm.pasien');

    // SPK
    Route::get('/spk', [Admin\SpkController::class, 'index'])->name('spk');

    // Kelola Dokter
    Route::resource('dokter', Admin\DokterController::class);

    // Kelola Jadwal
    Route::get('/jadwal', [Admin\JadwalController::class, 'index'])->name('jadwal.index');
    Route::post('/jadwal', [Admin\JadwalController::class, 'store'])->name('jadwal.store');
    Route::put('/jadwal/{id}', [Admin\JadwalController::class, 'update'])->name('jadwal.update');
    Route::delete('/jadwal/{id}', [Admin\JadwalController::class, 'destroy'])->name('jadwal.destroy');

    // Kelola Antrean
    Route::get('/antrean', [Admin\AntreanController::class, 'index'])->name('antrean.index');
    Route::put('/antrean/{id}/status', [Admin\AntreanController::class, 'updateStatus'])->name('antrean.status');

    // Kelola Pengguna (CRUD)
    Route::resource('pengguna', Admin\PenggunaController::class);

    // Pembayaran
    Route::get('/pembayaran/verifikasi', [Admin\PembayaranController::class, 'verifikasi'])->name('pembayaran.verifikasi');
    Route::post('/pembayaran/{id}/approve', [Admin\PembayaranController::class, 'approve'])->name('pembayaran.approve');
    Route::post('/pembayaran/{id}/tolak', [Admin\PembayaranController::class, 'tolak'])->name('pembayaran.tolak');
    Route::get('/pembayaran/riwayat', [Admin\PembayaranController::class, 'riwayat'])->name('pembayaran.riwayat');

    // Laporan
    Route::get('/laporan', [Admin\LaporanController::class, 'index'])->name('laporan');
    Route::get('/laporan/export', [Admin\LaporanController::class, 'export'])->name('laporan.export');

    // Lihat chat (admin)
    Route::get('/chat/{bookingId}', [ChatController::class, 'room'])->name('chat.room');
});

// =============================================
// PANEL DOKTER
// =============================================
Route::middleware(['auth', 'nocache', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [Dokter\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/riwayat', [Dokter\DashboardController::class, 'riwayat'])->name('riwayat');
    Route::post('/update-status/{id}', [Dokter\DashboardController::class, 'updateStatus'])->name('update.status');
});

// =============================================
// PANEL PASIEN
// =============================================
Route::middleware(['auth', 'nocache', 'role:pasien'])->prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/dashboard', [Pasien\DashboardController::class, 'index'])->name('dashboard');

    // Booking
    Route::get('/booking', [Pasien\BookingController::class, 'index'])->name('booking.index');
    Route::post('/booking', [Pasien\BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/riwayat', [Pasien\BookingController::class, 'riwayat'])->name('booking.riwayat');

    // Pembayaran (Midtrans)
    Route::get('/pembayaran/{bookingId}', [Pasien\PembayaranController::class, 'show'])->name('pembayaran.show');
    Route::post('/pembayaran/{bookingId}/snap-token', [Pasien\PembayaranController::class, 'getSnapToken'])->name('pembayaran.snap');

    // Antrean Offline
    Route::get('/antrean', [Pasien\AntreanController::class, 'index'])->name('antrean.index');
    Route::post('/antrean', [Pasien\AntreanController::class, 'store'])->name('antrean.store');
    Route::get('/antrean/riwayat', [Pasien\AntreanController::class, 'riwayat'])->name('antrean.riwayat');

    // Ulasan
    Route::get('/ulasan/{bookingId}', [Pasien\UlasanController::class, 'show'])->name('ulasan.show');
    Route::post('/ulasan/{bookingId}', [Pasien\UlasanController::class, 'store'])->name('ulasan.store');
});

// =============================================
// CHAT (pasien & dokter)
// =============================================
Route::middleware(['auth', 'nocache'])->prefix('chat')->name('chat.')->group(function () {
    Route::get('/{bookingId}', [ChatController::class, 'room'])->name('room');
    Route::get('/{bookingId}/messages', [ChatController::class, 'getMessages'])->name('messages');
    Route::post('/{bookingId}/send', [ChatController::class, 'sendMessage'])->name('send');
    Route::post('/{bookingId}/end', [ChatController::class, 'endSession'])->name('end');
    Route::get('/{bookingId}/download', [ChatController::class, 'downloadChat'])->name('download');
});

// =============================================
// MIDTRANS WEBHOOK (no CSRF)
// =============================================
Route::post('/midtrans/webhook', [MidtransWebhookController::class, 'handle'])
    ->name('midtrans.webhook')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
