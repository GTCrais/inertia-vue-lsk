<?php

namespace App\Bootstrappers;

use App\Http\Middleware\EnsureMobileDeviceUniqueness;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\RequestType;
use App\Http\Middleware\SanctumMiddleware;
use App\Http\Middleware\ThrottleSuccessfulRequests;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class MiddlewareRegistrar
{
	public static function register(Middleware $middleware)
	{
		$middleware->statefulApi();

		$middleware->validateCsrfTokens(except: [
			'api/mobile/v1/social-auth/*/oauth/callback',
		]);

		$middleware->replaceInGroup('api', EnsureFrontendRequestsAreStateful::class, SanctumMiddleware::class);
		$middleware->appendToGroup('web', HandleInertiaRequests::class);
		$middleware->appendToGroup('api', HandleInertiaRequests::class);

		$middleware->redirectGuestsTo(fn() => route('login.show'));
		$middleware->redirectUsersTo(fn() => route('user-account.show'));

		$middleware->alias([
			'throttleSuccessfulRequests' => ThrottleSuccessfulRequests::class,
			'requestType' => RequestType::class,
			'ensureMobileDeviceUniqueness' => EnsureMobileDeviceUniqueness::class
		]);
	}
}