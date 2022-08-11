<?php

return [
    'registration' => env('REGISTRATION', true),
    'registrationday' => env('REGISTRATION_DAY', '20220725'),
    'eventname' => env('EVENT_NAME', 'Hari Keluarga 2022'),
    'eventday' => env('EVENT_DAY', '20220821'),
    'paymentday' => env('PAYMENT_DAY', '20220821'),
    'banking' => [
        'bank' => env('BANKING_BANK', 'Bank Islam Malaysia Berhad'),
        'number' => env('BANKING_NUMBER', '14180010000531'),
        'name' => env('BANKING_NAME', 'Kelab TM Ibu Pejabat'),
        'maxupload' => 3096,
    ],
    // All rates must be in Sen domination
    'rate' => [
        'adult' => [
            'member' => 1500,
            'nonmember' => 2500,
            'nonmember_old' => 5000,
            'others' => 5000,
        ],
        'kids' => [
            'member' => 1000,
            'nonmember' => 1000,
            'nonmember_old' => 2000,
            'others' => 2000,
        ],
        'infant' => [
            'others' => 0,
        ],
        'oku' => [
            'others' => 0,
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
