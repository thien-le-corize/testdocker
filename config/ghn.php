<?php 
return [
    'token' => env('TOKEN'),
    'api' => [
        'province' => 'https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/province',
        'district' => 'https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/district',
        'ward' => 'https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/ward',
        'create_shop' => 'https://dev-online-gateway.ghn.vn/shiip/public-api/v2/shop/register',
        'order_shipping_fee' => 'https://dev-online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee',
        'create_order' => 'https://dev-online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/create',
        'gen_token' => 'https://dev-online-gateway.ghn.vn/shiip/public-api/v2/a5/gen-token',
        'print' => 'https://dev-online-gateway.ghn.vn/a5/public-api/printA5'
    ]
];