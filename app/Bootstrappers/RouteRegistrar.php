<?php

namespace App\Bootstrappers;

use Illuminate\Support\Facades\Route;

class RouteRegistrar
{
	public static function register()
	{
		/*Route::middleware('api')
			->prefix('api')
			->group(base_path('routes/api.php'));*/

		Route::middleware('api')
			->group(base_path('routes/web.php'));
	}
}