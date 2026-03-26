<?php

namespace App\Services;

class MidtransService
{
    private string $serverKey;
    private string $snapUrl;

    public function __construct()
    {
        $this->serverKey = config('midtrans.server_key');
        $this->snapUrl   = config('midtrans.snap_url');
    }

    /**
     * Membuat Snap Token dari Midtrans
     */
    public function getSnapToken(array $payload): ?string
    {
        $authString = base64_encode($this->serverKey . ':');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->snapUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Basic ' . $authString,
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 201) {
            $data = json_decode($response, true);
            return $data['token'] ?? null;
        }

        \Log::error("Midtrans Snap Error (Code: $httpCode): $response");
        return null;
    }

    /**
     * Verifikasi signature key dari Midtrans webhook
     */
    public function verifySignature(string $orderId, string $statusCode, string $grossAmount, string $signatureKey): bool
    {
        $hash = hash('sha512', $orderId . $statusCode . $grossAmount . $this->serverKey);
        return hash_equals($hash, $signatureKey);
    }
}
