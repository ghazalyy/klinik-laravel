<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Pembayaran;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    private MidtransService $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }

    public function show($bookingId)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('pasien_id', Auth::id())
            ->with(['dokter.user', 'pembayaran'])
            ->firstOrFail();

        $clientKey = config('midtrans.client_key');
        $isProduction = config('midtrans.is_production');

        return view('pasien.pembayaran.show', compact('booking', 'clientKey', 'isProduction'));
    }

    public function getSnapToken($bookingId)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('pasien_id', Auth::id())
            ->with(['pasien', 'dokter.user', 'pembayaran'])
            ->firstOrFail();

        if ($booking->status_pembayaran === 'lunas') {
            return response()->json(['error' => 'Booking sudah dibayar.'], 400);
        }

        $payload = [
            'transaction_details' => [
                'order_id'    => 'booking-' . $booking->id,
                'gross_amount' => (int) $booking->pembayaran->jumlah_bayar,
            ],
            'customer_details' => [
                'first_name' => $booking->pasien->nama_lengkap,
                'phone'      => $booking->pasien->no_telepon ?? '-',
            ],
            'item_details' => [
                [
                    'id'       => 'konsultasi-' . $booking->dokter->id,
                    'price'    => (int) $booking->pembayaran->jumlah_bayar,
                    'quantity' => 1,
                    'name'     => 'Konsultasi dengan ' . $booking->dokter->user->nama_lengkap,
                ]
            ],
        ];

        $token = $this->midtrans->getSnapToken($payload);

        if (!$token) {
            return response()->json(['error' => 'Gagal membuat token Midtrans.'], 500);
        }

        return response()->json(['token' => $token]);
    }
}
