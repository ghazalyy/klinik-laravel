<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function verifikasi()
    {
        $pembayarans = Pembayaran::with(['booking.pasien', 'booking.dokter.user'])
            ->whereHas('booking', fn($q) => $q->where('status_pembayaran', 'pending'))
            ->whereNotNull('bukti_transfer')
            ->whereNull('midtrans_order_id')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.pembayaran.verifikasi', compact('pembayarans'));
    }

    public function approve($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->booking->update(['status_pembayaran' => 'lunas']);
        $pembayaran->update(['verifikasi_oleh_admin_id' => Auth::id()]);
        return redirect()->route('admin.pembayaran.verifikasi')->with('success', 'Pembayaran disetujui.');
    }

    public function tolak($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->booking->update(['status_pembayaran' => 'ditolak']);
        return redirect()->route('admin.pembayaran.verifikasi')->with('success', 'Pembayaran ditolak.');
    }

    public function riwayat()
    {
        $pembayarans = Pembayaran::with(['booking.pasien', 'booking.dokter.user'])
            ->orderByDesc('created_at')
            ->paginate(20);
        return view('admin.pembayaran.riwayat', compact('pembayarans'));
    }
}
