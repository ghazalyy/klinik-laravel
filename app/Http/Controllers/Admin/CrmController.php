<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use App\Models\AntreanOffline;
use Illuminate\Support\Facades\DB;

class CrmController extends Controller
{
    public function dashboard()
    {
        // 6 stat cards
        $totalPasien       = User::where('role', 'pasien')->count();
        $pasienBaru        = User::where('role', 'pasien')->whereMonth('created_at', now()->month)->count();
        $totalBooking      = Booking::count();
        $bookingBulanIni   = Booking::whereMonth('tanggal_booking', now()->month)->count();
        $totalAntrean      = AntreanOffline::count();
        $pasienSelesai     = Booking::where('status_sesi', 'selesai')->distinct('pasien_id')->count('pasien_id');

        // Tren kunjungan 6 bulan terakhir
        $trendData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $trendData[] = [
                'bulan' => $date->format('M Y'),
                'jumlah' => Booking::whereYear('tanggal_booking', $date->year)
                    ->whereMonth('tanggal_booking', $date->month)
                    ->count(),
            ];
        }

        // Dokter paling banyak booking (top 5)
        $dokterPopuler = Booking::select('dokter_id', DB::raw('count(*) as total'))
            ->with('dokter.user')
            ->groupBy('dokter_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Pasien tidak aktif (tidak ada booking dalam 90 hari)
        $pasienTidakAktif = User::where('role', 'pasien')
            ->whereDoesntHave('bookings', fn($q) => $q->where('tanggal_booking', '>=', now()->subDays(90)))
            ->limit(20)
            ->get();

        return view('admin.crm.dashboard', compact(
            'totalPasien', 'pasienBaru', 'totalBooking', 'bookingBulanIni',
            'totalAntrean', 'pasienSelesai', 'trendData', 'dokterPopuler', 'pasienTidakAktif'
        ));
    }

    public function detailPasien($id)
    {
        $pasien   = User::findOrFail($id);
        $bookings = Booking::where('pasien_id', $id)->with(['dokter.user', 'pembayaran', 'reviewDokter'])->orderByDesc('tanggal_booking')->get();
        $antrean  = AntreanOffline::where('pasien_id', $id)->with('dokter.user')->orderByDesc('tanggal_kunjungan')->get();

        return view('admin.crm.pasien', compact('pasien', 'bookings', 'antrean'));
    }
}
