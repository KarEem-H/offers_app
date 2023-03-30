<?php

return [
    /**
     * Tamara url
     */
    'token' => env('TOKEN'),

    /**
     * Tamara token
     */
    'url' => env('URL'),

    /**
     * Tamara notification token
     */
    'notification_token' => env('NOTIFICATION_TOKEN'),

    /**
     * Website url
     */
    'front_end_url' => env('FRONT_END_URL'),

    /**
     * Backend url
     */
    'backend_url' => env('BACKEND_URL'),

    /**
     * Tamara payment types
     */
    'payment_types' => [
        // 'PAY_BY_LATER' => [
        //     "name" => "PAY_BY_LATER",
        //     "description" => "Pay later within 30 days. No fees",
        //     "description_ar" => "اطلب الآن وادفع خلال 30 یوم بدون رسوم",
        //     "min_limit" => [
        //         "amount"  =>100,
        //         "currency" => "SAR"
        //     ],
        //     "max_limit" => [
        //         "amount" => 500,
        //         "currency" => "SAR"
        //     ]
        // ],
        'PAY_BY_INSTALMENTS' => [
            "name" => "PAY_BY_INSTALMENTS",
            "description" => "Split into multiple payments. No fees",
            "description_ar" => "قسمها على دفعات بدون رسوم",
            "min_limit" => [
                "amount"  =>99,
                "currency" => "SAR"
            ],
            "max_limit" => [
                "amount" => 1500,
                "currency" => "SAR"
            ]
        ]
    ]
];
