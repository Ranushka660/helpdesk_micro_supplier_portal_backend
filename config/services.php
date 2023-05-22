<?php

return [
    'api_gateway' => [
        'base_uri' => env('API_GATEWAY_URI'),
        'secret' => env('SECRET')
    ],

    'procurement' => [
        'base_uri' => env('PROCUREMENT_SERVICE_URI'),
        'secret' => env('SECRET')
    ],

    'front_end' => [
        'base_uri' => env('FRONT_END_URI'),
    ],
];
