<?php

return [
    'registration' => env('REGISTRATION', true),
    'eventname' => env('EVENT_NAME', 'Hari Keluarga 2022'),
    'eventday' => env('EVENT_DAY', '20220821'),
    'paymentday' => env('PAYMENT_DAY', '20220821'),
    'banking' => [
        'bank' => env('BANKING_BANK', 'Bank Islam'),
        'number' => env('BANKING_NUMBER', '1234-5667-89'),
        'name' => env('BANKING_NAME', 'Kelab TM'),
    ],
    // All rates must be in sen domination
    'rate' => [
        'adult' => [
            'member' => 1500,
            'nonmember' => 3500,
            'others' => 3500,
        ],
        'kids' => [
            'member' => 1000,
            'nonmember' => 2500,
            'others' => 2500,
        ],
    ],
    'counters' => [
        [
            'date' => '20220225',
            'location' => 'MPH@Menara TM',
        ],
        [
            'date' => '20220226',
            'location' => 'MPH@Menara TM',
        ],
        [
            'date' => '20220303',
            'location' => 'Menara TM',
        ],
        [
            'date' => '20220304',
            'location' => 'Menara TM',
        ],
        [
            'date' => '20220305',
            'location' => 'TM Annexe 2',
        ],
        [
            'date' => '20220306',
            'location' => 'TM One',
        ],
        [
            'date' => '20220309',
            'location' => 'TM One',
        ],
    ],
];
