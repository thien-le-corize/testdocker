<?php
return [
    'precision' => 20,
    'user_site_url' => env('USER_SITE_URL'),
    'uploads' => [
        'folder_categories' => 'uploads/categories/',
        'folder_products' => 'uploads/products/',
        'default_shop_image' => 'uploads/default-avatar.jpeg'
    ],
    'product' => [
        'status' => [
            1 => 'reviewing',
            2 => 'banned',
            3 => 'active',
            4 => 'inactive',
            5 => 'soldout,'
        ]
    ],
    'order' => [
        'payment_method' => [
            1 => 'cash_on_delivery',
            2 => 'vnpay',
            3 => 'momo'
        ],
        'status' => [
            1 => 'unpaid',
            2 => 'toship',
            3 => 'shipping',
            4 => 'completed',
            5 => 'cancelled',
            6 => 'refund',
            7 => 'failed_delivery', 
        ]
    ],
    'vnp' => [
        'vnp_TmnCode' => env('VNP_TMNCODE'),
        'vnp_HashSecret' => env('VNP_HASHSECRET'),
        'vnp_Url' => env('VNP_URL')
    ]
];
