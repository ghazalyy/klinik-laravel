<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class PaymentkuService
{
    private string $apiKey;
    private string $webhookSecret;
    private bool $sandbox;

    public function __construct()
    {
        $this->apiKey        = config('paymentku.api_key') ?: '';
        $this->webhookSecret = config('paymentku.webhook_secret') ?: '';
        $this->sandbox       = config('paymentku.sandbox', true);
    }

    /**
     * Membuat transaksi. Jika API key diatur, ia akan memanggil endpoint asli paymenku.com.
     * Jika tidak, ia akan fallback ke simulator lokal.
     */
    public function createTransaction(string $orderId, float $amount, array $customer = []): string
    {
        // Jika tidak ada API key, gunakan simulator lokal
        if (empty($this->apiKey) || $this->apiKey === 'pk_live_51MszD8FUMwD2x0Hl') {
            return $this->generateSimulatorUrl($orderId, $amount);
        }

        $url = 'https://paymenku.com/api/v1/transaction/create';

        $payload = [
            'channel_code'   => 'qris', // Default menggunakan QRIS
            'amount'         => (int) $amount,
            'reference_id'   => $orderId,
            'customer_name'  => $customer['name'] ?? 'Pasien Klinik Orinda',
            'customer_email' => $customer['email'] ?? 'pasien@klinikorinda.com',
            'customer_phone' => $customer['phone'] ?? '081234567890',
            'return_url'     => route('pasien.booking.riwayat'),
        ];

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $this->apiKey,
                'Content-Type: application/json',
                'Accept: application/json',
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode == 200 || $httpCode == 201) {
                $data = json_decode($response, true);
                if (isset($data['status']) && $data['status'] === 'success' && isset($data['data']['pay_url'])) {
                    return $data['data']['pay_url'];
                }
            }

            Log::error("Paymenku API Error (Code: $httpCode): " . $response);
        } catch (\Exception $e) {
            Log::error("Paymenku Connection Error: " . $e->getMessage());
        }

        // Fallback ke simulator jika API gagal terhubung atau error
        return $this->generateSimulatorUrl($orderId, $amount);
    }

    /**
     * Memverifikasi signature callback webhook dari Paymenku
     * Rumus: HMAC-SHA256(timestamp + "." + rawBody, webhookSecret)
     */
    public function verifyWebhookSignature(string $timestamp, string $rawBody, string $receivedSignature): bool
    {
        $secret = $this->webhookSecret ?: $this->apiKey;
        if (empty($secret)) {
            return false;
        }

        $calculated = hash_hmac('sha256', $timestamp . '.' . $rawBody, $secret);
        return hash_equals($calculated, $receivedSignature);
    }

    /**
     * Menghasilkan signature untuk webhook simulator
     */
    public function generateWebhookSignature(string $timestamp, string $rawBody): string
    {
        $secret = $this->webhookSecret ?: $this->apiKey;
        return hash_hmac('sha256', $timestamp . '.' . $rawBody, $secret);
    }

    /**
     * Generator URL simulator
     */
    private function generateSimulatorUrl(string $orderId, float $amount): string
    {
        $token = base64_encode(json_encode([
            'order_id'   => $orderId,
            'amount'     => $amount,
            'created_at' => time()
        ]));

        return route('paymentku.checkout', ['token' => $token]);
    }
}
