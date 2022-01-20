<?php

return [
    //Web Credentials
    'web'     => [
        'key'    => env('WEB_APP_KEY', 'web_app_key'),
        'secret' => env('WEB_APP_SECRET', 'web_app_secret'),
    ],
    //Android Credentials
    'android' => [
        'key'    => env('WEB_APP_KEY', 'android_app_key'),
        'secret' => env('WEB_APP_SECRET', 'android_app_secret'),
    ],
    //iOS Credentials
    'ios'     => [
        'key'    => env('WEB_APP_KEY', 'ios_app_key'),
        'secret' => env('WEB_APP_SECRET', 'ios_app_secret'),
    ],
];
