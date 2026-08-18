<?php

namespace App\Bootstrappers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

class RouteRegistrar
{
	public static function register()
	{
		Route::middleware('api')
			->prefix('api/mobile/v1')
			->name('api.mobile.v1.')
			->group(base_path('routes/mobile_v1.php'));

		Route::middleware('api')
			->group(base_path('routes/auth.php'));

		Route::middleware('api')
			->group(base_path('routes/web.php'));

		Broadcast::routes();
	}

	public static function channels()
	{
		return __DIR__ . '/../../routes/channels.php';
	}
}