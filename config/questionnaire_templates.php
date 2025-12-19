<?php

return [
    'casual_dining' => [
        'name' => 'Casual Dining',
        'icon' => 'utensils',
        'description' => 'Ideal untuk restoran keluarga dan casual dining.',
        'questions' => [
            [
                'id' => 'q1',
                'text' => 'Bagaimana kualitas makanan kami?',
                'type' => 'rating',
                'options' => [],
                'required' => true,
            ],
            [
                'id' => 'q2',
                'text' => 'Bagaimana pelayanan staff kami?',
                'type' => 'rating',
                'options' => [],
                'required' => true,
            ],
            [
                'id' => 'q3',
                'text' => 'Kebersihan restoran?',
                'type' => 'rating',
                'options' => [],
                'required' => true,
            ],
            [
                'id' => 'q4',
                'text' => 'Apakah harga sesuai dengan kualitas?',
                'type' => 'boolean',
                'options' => ['Ya', 'Tidak'],
                'required' => false,
            ],
            [
                'id' => 'q5',
                'text' => 'Saran atau masukan lainnya?',
                'type' => 'text',
                'options' => [],
                'required' => false,
            ],
        ],
    ],
    'cafe' => [
        'name' => 'Café / Coffee Shop',
        'icon' => 'coffee',
        'description' => 'Fokus pada suasana, rasa kopi, dan kecepatan.',
        'questions' => [
            [
                'id' => 'q1',
                'text' => 'Bagaimana rasa minuman/kopi kami?',
                'type' => 'rating',
                'options' => [],
                'required' => true,
            ],
            [
                'id' => 'q2',
                'text' => 'Bagaimana suasana/ambience cafe?',
                'type' => 'rating',
                'options' => [],
                'required' => true,
            ],
            [
                'id' => 'q3',
                'text' => 'Kecepatan penyajian?',
                'type' => 'rating',
                'options' => [],
                'required' => true,
            ],
            [
                'id' => 'q4',
                'text' => 'Wifi lancar?',
                'type' => 'boolean',
                'options' => ['Ya', 'Tidak'],
                'required' => false,
            ],
        ],
    ],
    'fast_food' => [
        'name' => 'Fast Food',
        'icon' => 'hamburger',
        'description' => 'Quick service restaurant feedback.',
        'questions' => [
            [
                'id' => 'q1',
                'text' => 'Kecepatan pelayanan?',
                'type' => 'rating',
                'options' => [],
                'required' => true,
            ],
            [
                'id' => 'q2',
                'text' => 'Rasa makanan?',
                'type' => 'rating',
                'options' => [],
                'required' => true,
            ],
            [
                'id' => 'q3',
                'text' => 'Akurasi pesanan (sesuai order)?',
                'type' => 'boolean',
                'options' => ['Ya', 'Tidak'],
                'required' => true,
            ],
            [
                'id' => 'q4',
                'text' => 'Kebersihan area makan?',
                'type' => 'rating',
                'options' => [],
                'required' => true,
            ],
        ],
    ],
];
