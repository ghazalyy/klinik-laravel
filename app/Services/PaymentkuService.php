<?php

namespace App\Services;

class PaymentkuService
{
    private string $apiKey;
    private string $merchantId;
    private bool $sandbox;

    public function __construct()
    {
        $this->apiKey     = config('paymentku.api_key');
        $this->merchantId = config('paymentku.merchant_id');
        $this->sandbox    = config('paymentku.sandbox');
    }

    /**
     * Membuat transaksi Paymentku dan mengembalikan URL checkout simulator
       */
    public function createTransaction(string $orderId, float $amount): string
    {
        $token = base64_encode(json_encode([
            'order_id'   => $orderId,
            'amount'     => $amount,
            'created_at' => time()
        ]));

        return route('paymentku.checkout', ['token' => $token]);
    }

    /**
     * Memverifikasi signature callback webhook dari Paymentku
       */
    public function verifySignature(string $orderId, string $status, string $amount, string $signature): bool
    {
        $calculatedSignature = hash('sha256', $orderId . $status . $amount . $this->apiKey);
        return hash_equals($calculatedSignature, $signature);
    }

    /**
     * Menghasilkan signature untuk pengiriman webhook (digunakan oleh simulator)
       */
    public function generateSignature(string $orderId, string $status, string $amount): string
    {
        return hash('sha256', $orderId . $status . $amount . $this->apiKey);
    }
}
