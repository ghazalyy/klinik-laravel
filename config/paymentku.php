<?php

return [
    'api_key'        => env('PAYMENKU_API_KEY', ''),
    'webhook_secret' => env('PAYMENKU_WEBHOOK_SECRET', ''),
    'sandbox'        => env('PAYMENKU_SANDBOX', true),
];
