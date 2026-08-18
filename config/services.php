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

	'facebook' => [
		'client_id' => env('FACEBOOK_CLIENT_ID'),
		'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
		'redirect' => '/'
	],

	'google' => [
		'client_id' => env('GOOGLE_CLIENT_ID'),
		'client_secret' => env('GOOGLE_CLIENT_SECRET'),
		'maps_api_key' => env('GOOGLE_MAPS_API_KEY'),
		'redirect' => '/'
	],

	'apple' => [
		'client_id' => env('APPLE_CLIENT_ID'), // Required. Bundle ID from Identifier in Apple Developer.
		'client_secret' => env('APPLE_CLIENT_SECRET'), // Empty. We create it from private key.
		'key_id' => env('APPLE_KEY_ID'), // Required. Key ID from Keys in Apple Developer.
		'team_id' => env('APPLE_TEAM_ID'), // Required. App ID Prefix from Identifier in Apple Developer.
		'private_key' => base_path(env('APPLE_PRIVATE_KEY')), // Required. Must be absolute path, e.g. /var/www/cert/AuthKey_XYZ.p8
		'redirect' => '/'
	],

	'fathom' => [
		'active' => env('FATHOM_ACTIVE', false)
	],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
