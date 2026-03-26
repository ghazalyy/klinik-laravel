<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Pembayaran;
use App\Services\MidtransService;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $data = $request->all();

        $orderId     = $data['order_id'] ?? '';
        $statusCode  = $data['status_code'] ?? '';
        $grossAmount = $data['gross_amount'] ?? '';
        $signatureKey = $data['signature_key'] ?? '';
        $transactionStatus = $data['transaction_status'] ?? '';
        $fraudStatus = $data['fraud_status'] ?? '';

        $midtrans = app(MidtransService::class);
        if (!$midtrans->verifySignature($orderId, $statusCode, $grossAmount, $signatureKey)) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // order_id format: booking-{booking_id}
        $bookingId = str_replace('booking-', '', $orderId);
        $booking = Booking::find($bookingId);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        if (($transactionStatus === 'capture' && $fraudStatus === 'accept')
            || $transactionStatus === 'settlement') {
            $booking->update(['status_pembayaran' => 'lunas']);
            if ($booking->pembayaran) {
                $booking->pembayaran->update([
                    'midtrans_order_id' => $orderId,
                    'midtrans_status'   => $transactionStatus,
                    'metode_pembayaran' => 'Midtrans',
                ]);
            }
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel', 'failure'])) {
            $booking->update(['status_pembayaran' => 'ditolak']);
        }

        return response()->json(['message' => 'OK'], 200);
    }
}
