<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\PaymentkuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentkuWebhookController extends Controller
{
    private PaymentkuService $paymentku;

    public function __construct(PaymentkuService $paymentku)
    {
        $this->paymentku = $paymentku;
    }

    public function handle(Request $request)
    {
        $orderId   = $request->input('order_id');
        $status    = $request->input('status');
        $amount    = $request->input('amount');
        $signature = $request->input('signature');

        if (!$this->paymentku->verifySignature($orderId, $status, $amount, $signature)) {
            return response()->json(['message' => 'Signature key tidak valid'], 403);
        }

        // Format order ID: booking-{booking_id}
        $bookingId = str_replace('booking-', '', $orderId);
        $booking   = Booking::with('pembayaran')->find($bookingId);

        if (!$booking) {
            return response()->json(['message' => 'Booking tidak ditemukan'], 404);
        }

        if ($status === 'success') {
            $booking->update(['status_pembayaran' => 'lunas']);
            if ($booking->pembayaran) {
                $booking->pembayaran->update([
                    'midtrans_order_id' => $orderId,
                    'midtrans_status'   => 'success',
                    'metode_pembayaran' => 'Paymentku',
                ]);
            }
            Log::info("Paymentku: Pembayaran untuk Booking #{$bookingId} berhasil diverifikasi.");
        } else {
            $booking->update(['status_pembayaran' => 'ditolak']);
            Log::warning("Paymentku: Pembayaran untuk Booking #{$bookingId} gagal/ditolak.");
        }

        return response()->json(['message' => 'OK']);
    }
}
