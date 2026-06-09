<?php

return [
    'api_key'      => env('PAYMENTKU_API_KEY', 'pk_live_51MszD8FUMwD2x0Hl'),
    'merchant_id'  => env('PAYMENTKU_MERCHANT_ID', 'merchant_orinda'),
    'sandbox'      => env('PAYMENTKU_SANDBOX', true),
    'checkout_url' => '/paymentku/pay',
];
