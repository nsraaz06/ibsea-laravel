<?php

return [
    'app_id' => env('CASHFREE_APP_ID'),
    'secret_key' => env('CASHFREE_SECRET_KEY'),
    'mode' => env('CASHFREE_MODE', 'TEST'),
    'api_version' => env('CASHFREE_API_VERSION', '2023-08-01'),
    'url' => env('CASHFREE_MODE') === 'PRODUCTION' 
                ? env('CASHFREE_URL_PROD', 'https://api.cashfree.com/pg/orders') 
                : env('CASHFREE_URL_TEST', 'https://sandbox.cashfree.com/pg/orders'),
];
