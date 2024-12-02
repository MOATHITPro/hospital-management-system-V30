<?php

return [

    'default' => env('MAIL_MAILER', 'smtp'), // Mailer الافتراضي

    'mailers' => [

        'mercury' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST_MERCURY', '127.0.0.1'),
            'port' => env('MAIL_PORT_MERCURY', 25),
            'encryption' => env('MAIL_ENCRYPTION_MERCURY', null),
            'username' => env('MAIL_USERNAME_MERCURY', null),
            'password' => env('MAIL_PASSWORD_MERCURY', null),
            'timeout' => null,
            'auth_mode' => null,
        ],

    ],

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'default@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Default Name'),
    ],

];
