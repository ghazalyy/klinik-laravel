<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Pembayaran;

class LaporanController extends Controller
{
    public function index()
    {
        $totalPendapatan = Pembayaran::whereHas('booking', fn($q) => $q->where('status_pembayaran', 'lunas'))->sum('jumlah_bayar');
        $bookingSelesai  = Booking::where('status_sesi', 'selesai')->count();
        $bookingBulanIni = Booking::whereMonth('tanggal_booking', now()->month)->count();
        $pasienTerdaftar = User::where('role', 'pasien')->count();

        $bookings = Booking::with(['pasien', 'dokter.user', 'pembayaran'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.laporan', compact(
            'totalPendapatan', 'bookingSelesai', 'bookingBulanIni', 'pasienTerdaftar', 'bookings'
        ));
    }

    public function export()
    {
        $bookings = Booking::with(['pasien', 'dokter.user', 'pembayaran'])->get();
        $filename = "Laporan_Klinik_Orinda_" . date('Y-m-d') . ".csv";
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID Booking', 'Nama Pasien', 'Nama Dokter', 'Tanggal', 'Biaya', 'Status Bayar', 'Status Sesi'];

        $callback = function() use($bookings, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($bookings as $b) {
                fputcsv($file, [
                    $b->id,
                    $b->pasien->nama_lengkap,
                    $b->dokter->user->nama_lengkap,
                    $b->tanggal_booking->format('Y-m-d'),
                    $b->pembayaran->jumlah_bayar ?? 0,
                    $b->status_pembayaran,
                    $b->status_sesi
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
