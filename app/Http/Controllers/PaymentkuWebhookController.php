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
        $timestamp = $request->header('X-PaymenKu-Timestamp');
        $signature = $request->header('X-PaymenKu-Signature');
        $rawBody   = $request->getContent();

        // Cek jika request dari simulator lokal (menggunakan query parameter/POST data biasa)
        if (!$signature && $request->has('signature')) {
            $orderId   = $request->input('order_id');
            $status    = $request->input('status');
            $amount    = $request->input('amount');
            $signature = $request->input('signature');
            
            // Verifikasi menggunakan data simulator
            $simulationBody = $orderId . '.' . $status . '.' . $amount;
            if (!$this->paymentku->verifyWebhookSignature('0', $simulationBody, $signature)) {
                return response()->json(['message' => 'Signature key tidak valid (simulator)'], 403);
            }
        } else {
            // Verifikasi request resmi dari API paymenku.com
            if (empty($timestamp) || empty($signature) || !$this->paymentku->verifyWebhookSignature($timestamp, $rawBody, $signature)) {
                return response()->json(['message' => 'Signature key tidak valid'], 403);
            }

            $data = json_decode($rawBody, true);
            $orderId = $data['reference_id'] ?? '';
            $status  = $data['status'] ?? '';
        }

        // Format order ID: booking-{booking_id}
        $bookingId = str_replace('booking-', '', $orderId);
        $booking   = Booking::with('pembayaran')->find($bookingId);

        if (!$booking) {
            return response()->json(['message' => 'Booking tidak ditemukan'], 404);
        }

        // Status sukses di Paymenku = 'paid', di simulator = 'success'
        if ($status === 'paid' || $status === 'success') {
            $booking->update(['status_pembayaran' => 'lunas']);
            if ($booking->pembayaran) {
                $booking->pembayaran->update([
                    'midtrans_order_id' => $orderId,
                    'midtrans_status'   => $status,
                    'metode_pembayaran' => 'Paymenku',
                ]);
            }
            Log::info("Paymenku: Pembayaran untuk Booking #{$bookingId} berhasil diverifikasi.");
        } else {
            $booking->update(['status_pembayaran' => 'ditolak']);
            Log::warning("Paymenku: Pembayaran untuk Booking #{$bookingId} ditolak/gagal.");
        }

        return response()->json(['message' => 'OK']);
    }
}
