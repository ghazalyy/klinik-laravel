<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Dokter;
use App\Models\JadwalDokter;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $dokters = Dokter::with(['user', 'jadwalDokter'])->get();
        return view('pasien.booking.index', compact('dokters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dokter_id'       => 'required|exists:dokter,id',
            'jadwal_id'       => 'nullable|exists:jadwal_dokter,id',
            'tanggal_booking' => 'required|date|after_or_equal:today',
        ]);

        $dokter = Dokter::findOrFail($validated['dokter_id']);

        $booking = Booking::create([
            'pasien_id'       => Auth::id(),
            'dokter_id'       => $validated['dokter_id'],
            'jadwal_id'       => $validated['jadwal_id'] ?? null,
            'tanggal_booking' => $validated['tanggal_booking'],
            'status_pembayaran' => 'pending',
            'status_sesi'       => 'menunggu',
        ]);

        // Buat record pembayaran awal
        Pembayaran::create([
            'booking_id'        => $booking->id,
            'jumlah_bayar'      => $dokter->harga_sesi,
            'metode_pembayaran' => 'Midtrans',
        ]);

        return redirect()->route('pasien.pembayaran.show', $booking->id)
            ->with('success', 'Booking berhasil! Silakan lakukan pembayaran.');
    }

    public function riwayat()
    {
        $bookings = Booking::where('pasien_id', Auth::id())
            ->with(['dokter.user', 'pembayaran', 'reviewDokter'])
            ->orderByDesc('tanggal_booking')
            ->paginate(15);

        return view('pasien.booking.riwayat', compact('bookings'));
    }
}
