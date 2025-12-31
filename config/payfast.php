<?php
return [
    'merchant_id' => env('PAYFAST_MERCHANT_ID'),
    'merchant_key' => env('PAYFAST_MERCHANT_KEY'),
    'passphrase' => env('PAYFAST_PASSPHRASE'),
    'testing' => env('PAYFAST_TESTING', true),
    
    // PayFast webhook source domains for validation
    'allowed_webhook_hosts' => [
        'www.payfast.co.za',
        'sandbox.payfast.co.za',
        'w1w.payfast.co.za',
        'w2w.payfast.co.za',
    ],
];
