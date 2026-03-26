<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\AntreanOffline;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $bookingAktif   = Booking::where('pasien_id', $user->id)->where('status_sesi', '!=', 'selesai')->where('status_sesi', '!=', 'dibatalkan')->count();
        $bookingSelesai = Booking::where('pasien_id', $user->id)->where('status_sesi', 'selesai')->count();
        $antreanAktif   = AntreanOffline::where('pasien_id', $user->id)->whereIn('status', ['menunggu', 'dipanggil'])->count();

        $bookingsTerbaru = Booking::where('pasien_id', $user->id)
            ->with(['dokter.user'])
            ->orderByDesc('tanggal_booking')
            ->limit(5)
            ->get();

        return view('pasien.dashboard', compact('user', 'bookingAktif', 'bookingSelesai', 'antreanAktif', 'bookingsTerbaru'));
    }
}
