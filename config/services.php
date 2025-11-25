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

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
    'contact_form' => [
        'rate_limit_enabled' => env('CONTACT_FORM_RATE_LIMIT_ENABLED', true),
        'ip' => [
            'tier1' => [
                'limit' => env('CONTACT_FORM_IP_LIMIT_1', 3),
                'decay_minutes' => env('CONTACT_FORM_IP_DECAY_1', 10),
            ],
            'tier2' => [
                'limit' => env('CONTACT_FORM_IP_LIMIT_2', 5),
                'decay_minutes' => env('CONTACT_FORM_IP_DECAY_2', 60),
            ],
            'tier3' => [
                'limit' => env('CONTACT_FORM_IP_LIMIT_3', 10),
                'decay_minutes' => env('CONTACT_FORM_IP_DECAY_3', 1440),
            ],
        ],
        'email' => [
            'limit' => env('CONTACT_FORM_EMAIL_LIMIT', 3),
            'decay_minutes' => env('CONTACT_FORM_EMAIL_DECAY', 60),
        ],
    ],


];
