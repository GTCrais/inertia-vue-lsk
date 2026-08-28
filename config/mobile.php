<?php

return [

	'header' => env('MOBILE_APP_HEADER'),
	'uriScheme' => env('MOBILE_APP_URI_SCHEME'),
	'deviceIdHeader' => env('MOBILE_APP_DEVICE_ID_HEADER'),
	'authTokenRotationDays' => env('MOBILE_APP_AUTH_TOKEN_ROTATION_DAYS', 7),
	'authTokenRotationGraceMinutes' => env('MOBILE_APP_AUTH_TOKEN_ROTATION_GRACE_MINUTES', 5),
	'authTokenMaxInactivityDays' => env('MOBILE_APP_AUTH_TOKEN_MAX_INACTIVITY_DAYS', 365)

];