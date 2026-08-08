<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    private \App\Services\PaymentkuService $paymentku;

    public function __construct(\App\Services\PaymentkuService $paymentku)
    {
        $this->paymentku = $paymentku;
    }

    public function show($bookingId)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('pasien_id', Auth::id())
            ->with(['dokter.user', 'pembayaran'])
            ->firstOrFail();

        return view('pasien.pembayaran.show', compact('booking'));
    }

    public function checkoutPaymentku($bookingId)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('pasien_id', Auth::id())
            ->with(['pembayaran', 'pasien'])
            ->firstOrFail();

        if ($booking->status_pembayaran === 'lunas') {
            return redirect()->route('pasien.booking.riwayat')->with('info', 'Booking ini sudah lunas.');
        }

        // Generate URL checkout Paymentku
        $checkoutUrl = $this->paymentku->createTransaction(
            'booking-' . $booking->id,
            (float) $booking->pembayaran->jumlah_bayar,
            [
                'name'  => $booking->pasien->nama_lengkap,
                'email' => $booking->pasien->email ?? 'pasien@klinikorinda.com',
                'phone' => $booking->pasien->no_telepon ?? '081234567890',
            ]
        );

        return redirect($checkoutUrl);
    }
}
