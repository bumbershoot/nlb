<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Gateway Services
    |--------------------------------------------------------------------------
    */

    'toyyibpay' => [
        'user_secret_key' => env('TOYYIBPAY_USER_SECRET_KEY'),
        'category_code' => env('TOYYIBPAY_CATEGORY_CODE'),
        'mode' => env('TOYYIBPAY_MODE', 'sandbox'), // 'sandbox' or 'production'
        'webhook_secret' => env('TOYYIBPAY_WEBHOOK_SECRET'),
    ],

    /*
    |--------------------------------------------------------------------------
    | E-Invoice Services
    |--------------------------------------------------------------------------
    */

    'einvoice' => [
        'api_url' => env('EINVOICE_API_URL'),
        'api_key' => env('EINVOICE_API_KEY'),
        'company_id' => env('EINVOICE_COMPANY_ID'),
        'mode' => env('EINVOICE_MODE', 'sandbox'), // 'sandbox' or 'production'
        'auto_submit' => env('EINVOICE_AUTO_SUBMIT', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Google Calendar Services
    |--------------------------------------------------------------------------
    */

    'google' => [
        'calendar' => [
            'credentials_path' => env('GOOGLE_CALENDAR_CREDENTIALS_PATH', storage_path('app/google-calendar-credentials.json')),
            'calendar_id' => env('GOOGLE_CALENDAR_ID', 'primary'),
            'auto_sync' => env('GOOGLE_CALENDAR_AUTO_SYNC', true),
        ],
    ],

];
