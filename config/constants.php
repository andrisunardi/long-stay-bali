<?php

return [
    // SLACK
    'slack' => [
        'sms' => env('SLACK_SMS'),
        'mail' => env('SLACK_MAIL'),
        'channel' => env('SLACK_CHANNEL'),
        'webhook_url' => env('LOG_SLACK_WEBHOOK_URL'),
    ],

    // CONTACT
    'contact' => [
        'whatsapp' => env('CONTACT_WHATSAPP'),
        'email' => env('CONTACT_EMAIL'),
        'address' => env('CONTACT_ADDRESS'),
        'google_maps' => env('CONTACT_GOOGLE_MAPS'),
        'google_maps_iframe' => env('CONTACT_GOOGLE_MAPS_IFRAME'),
    ],

    // GHL
    'ghl' => [
        'app_url' => env('GHL_APP_URL'),
        'url' => env('GHL_URL'),
        'oauth_url' => env('GHL_OAUTH_URL'),
        'client_id' => env('GHL_CLIENT_ID'),
        'client_secret' => env('GHL_CLIENT_SECRET'),
        'grant_type' => env('GHL_GRANT_TYPE'),
        'redirect_uri' => env('GHL_REDIRECT_URI'),
        'user_type' => env('GHL_USER_TYPE'),
        'location_id' => env('GHL_LOCATION_ID'),
        'version' => env('GHL_VERSION'),
    ],

    // EXCHANGE RATE
    'exchange_rate' => [
        'app_url' => env('EXCHANGE_RATE_APP_URL'),
        'url' => env('EXCHANGE_RATE_URL'),
        'token' => env('EXCHANGE_RATE_TOKEN'),
    ],

    // FOLDER
    'folder_id' => [
        'property' => env('FOLDER_ID_PROPERTY'),
        'user' => env('FOLDER_ID_USER'),
        'guide' => env('FOLDER_ID_GUIDE'),
    ],

    // META
    'meta' => [
        'title' => env('META_TITLE'),
        'description' => env('META_DESCRIPTION'),
        'color' => env('META_COLOR'),
    ],

    // ASSETS
    'assets' => [
        'path' => env('ASSETS_PATH', public_path()),
        'url' => env('ASSETS_URL'),
    ],

    // SOCIAL MEDIA
    'social_media' => [
        'facebook' => env('SOCIAL_MEDIA_FACEBOOK'),
        'instagram' => env('SOCIAL_MEDIA_INSTAGRAM'),
        'tiktok' => env('SOCIAL_MEDIA_TIKTOK'),
        'linkedin' => env('SOCIAL_MEDIA_LINKEDIN'),
    ],

    // FACEBOOK
    'facebook_id' => env('FACEBOOK_ID'),

    // GOOGLE
    'google_analytics_id' => env('GOOGLE_ANALYTICS_ID'),
];
