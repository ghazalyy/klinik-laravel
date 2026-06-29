<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\PaymentkuService;
use Illuminate\Http\Request;

class PaymentkuSimulatorController extends Controller
{
    private PaymentkuService $paymentku;

    public function __construct(PaymentkuService $paymentku)
    {
        $this->paymentku = $paymentku;
        if (!$this->paymentku->isSandbox()) {
            abort(403, 'Simulator is disabled in production/live mode.');
        }
    }

    public function checkout($token)
    {
        try {
            $decoded = json_decode(base64_decode($token), true);
            if (!$decoded || !isset($decoded['order_id'])) {
                abort(400, 'Token pembayaran tidak valid.');
            }

            $orderId   = $decoded['order_id'];
            $bookingId = str_replace('booking-', '', $orderId);
            $booking   = Booking::with(['pasien', 'dokter.user', 'pembayaran'])->findOrFail($bookingId);

            return view('paymentku.checkout', compact('booking', 'token', 'decoded'));
        } catch (\Exception $e) {
            abort(400, 'Gagal memproses token pembayaran.');
        }
    }

    public function pay(Request $request, $token)
    {
        try {
            $decoded = json_decode(base64_decode($token), true);
            if (!$decoded) {
                return redirect()->back()->with('error', 'Token pembayaran tidak valid.');
            }

            $orderId = $decoded['order_id'];
            $amount  = $decoded['amount'];
            $status  = 'success'; // Menyimulasikan transaksi berhasil

            // Generate signature menggunakan API key simulator
            $signature = $this->paymentku->generateWebhookSignature('0', $orderId . '.' . $status . '.' . $amount);

            // Panggil Webhook Controller secara programatik untuk menghindari deadlock single-thread php artisan serve
            $webhookController = app(PaymentkuWebhookController::class);
            $webhookRequest = Request::create(route('paymentku.webhook'), 'POST', [
                'order_id'  => $orderId,
                'status'    => $status,
                'amount'    => $amount,
                'signature' => $signature,
            ]);

            $response = $webhookController->handle($webhookRequest);
            $responseData = json_decode($response->getContent(), true);

            if ($response->getStatusCode() === 200) {
                return redirect()->route('pasien.booking.riwayat')
                    ->with('success', 'Pembayaran via Paymentku berhasil diverifikasi!');
            } else {
                return redirect()->back()->with('error', $responseData['message'] ?? 'Gagal memproses verifikasi pembayaran.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}
