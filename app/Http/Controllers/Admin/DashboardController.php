<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use App\Models\AntreanOffline;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPasien    = User::where('role', 'pasien')->count();
        $totalDokter    = User::where('role', 'dokter')->count();
        $totalBooking   = Booking::count();
        $pendingBayar   = Booking::where('status_pembayaran', 'pending')->count();
        $totalAntrean   = AntreanOffline::whereDate('tanggal_kunjungan', today())->count();
        $totalPendapatan = Pembayaran::whereHas('booking', fn($q) => $q->where('status_pembayaran', 'lunas'))->sum('jumlah_bayar');

        return view('admin.dashboard', compact(
            'totalPasien', 'totalDokter', 'totalBooking',
            'pendingBayar', 'totalAntrean', 'totalPendapatan'
        ));
    }
}
