<?php

namespace App\Bootstrappers;

use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\RequestType;
use App\Http\Middleware\SanctumMiddleware;
use App\Http\Middleware\ThrottleSuccessfulRequests;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\HandleCors;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class MiddlewareRegistrar
{
	public static function register(Middleware $middleware)
	{
		$middleware->statefulApi();

		$middleware->replace(\Illuminate\Http\Middleware\HandleCors::class, HandleCors::class);
		$middleware->replaceInGroup('api', EnsureFrontendRequestsAreStateful::class, SanctumMiddleware::class);
		$middleware->appendToGroup('web', HandleInertiaRequests::class);
		$middleware->appendToGroup('api', HandleInertiaRequests::class);

		$middleware->redirectGuestsTo(fn() => route('login.show'));
		$middleware->redirectUsersTo(fn() => route('user-account.show'));

		$middleware->alias([
			'throttleSuccessfulRequests' => ThrottleSuccessfulRequests::class,
			'requestSource' => RequestType::class,
		]);
	}
}