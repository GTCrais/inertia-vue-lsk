<?php

use Illuminate\Support\Str;

$appNameWords = Str::headline(env('MOBILE_APP_NAME', 'Laravel'));

return [

	'header' => env('MOBILE_APP_HEADER', 'X-'.str_replace(' ', '-', $appNameWords).'-Mobile'),
	'uriScheme' => env('MOBILE_APP_URI_SCHEME', str_replace(' ', '', mb_strtolower($appNameWords))),
	'deviceIdHeader' => env('MOBILE_APP_DEVICE_ID_HEADER', 'X-'.str_replace(' ', '-', $appNameWords).'-Device-Id'),
	'authTokenRotationDays' => env('MOBILE_APP_AUTH_TOKEN_ROTATION_DAYS', 7),
	'authTokenRotationGraceMinutes' => env('MOBILE_APP_AUTH_TOKEN_ROTATION_GRACE_MINUTES', 5),
	'authTokenMaxInactivityDays' => env('MOBILE_APP_AUTH_TOKEN_MAX_INACTIVITY_DAYS', 365),

];