<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $dokter = Auth::user()->dokter;
        if (!$dokter) {
            return redirect()->route('login')->with('error', 'Profil dokter tidak ditemukan.');
        }

        $bookingsHariIni = Booking::where('dokter_id', $dokter->id)
            ->whereDate('tanggal_booking', today())
            ->with('pasien')
            ->orderBy('waktu_mulai_sesi')
            ->get();

        return view('dokter.dashboard', compact('dokter', 'bookingsHariIni'));
    }

    public function riwayat()
    {
        $dokter = Auth::user()->dokter;
        $riwayat = Booking::where('dokter_id', $dokter->id)
            ->with(['pasien', 'reviewDokter'])
            ->orderByDesc('tanggal_booking')
            ->paginate(15);

        return view('dokter.riwayat', compact('dokter', 'riwayat'));
    }

    public function updateStatus(Request $request, $id)
    {
        $dokter = Auth::user()->dokter;
        $booking = Booking::where('id', $id)->where('dokter_id', $dokter->id)->firstOrFail();

        $validated = $request->validate([
            'status_sesi' => 'required|in:aktif,selesai,dibatalkan',
        ]);

        if ($validated['status_sesi'] === 'aktif') {
            $booking->update([
                'status_sesi'       => 'aktif',
                'waktu_mulai_sesi'  => now(),
            ]);
        } else {
            $booking->update(['status_sesi' => $validated['status_sesi']]);
        }

        return redirect()->route('dokter.dashboard')->with('success', 'Status sesi diperbarui.');
    }
}
