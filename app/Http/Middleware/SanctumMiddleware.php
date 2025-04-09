<?php

namespace App\Http\Middleware;

use Illuminate\Support\Str;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
/*
 * Why extend the original Sanctum middleware? Sanctum doesn't place nicely with Inertia.
 * Details here: https://github.com/laravel/sanctum/issues/482
 * In addition to fixing these issues, changes in this middleware allow for a custom mobile app header.
 */
class SanctumMiddleware extends EnsureFrontendRequestsAreStateful
{
	/**
	 * Handle the incoming requests.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  callable  $next
	 * @return \Illuminate\Http\Response
	 */
	public function handle($request, $next)
	{
		// If we're making a request from a mobile app, set the default guard to 'sanctum'. This
		// will allow us to access `$request->user()` on routes not protected by `auth:sanctum`
		if (static::fromMobile($request)) {
			config(['auth.defaults.guard' => 'sanctum']);
		}

		return parent::handle($request, $next);
	}

	public static function fromMobile($request)
	{
		return !static::fromFrontend($request);
	}

	/**
	 * Determine if the given request is from the first-party application frontend.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return bool
	 */
	public static function fromFrontend($request)
	{
		$mobileAppHeader = config('mobile.header');

		if ($mobileAppHeader && $request->hasHeader($mobileAppHeader)) {
			$request->merge(['from_frontend' => false]);

			return false;
		}

		$domains = [
			Str::of($request->headers->get('referer'))->replaceFirst('https://', '')->replaceFirst('http://', '')->value(),
			Str::of($request->headers->get('origin'))->replaceFirst('https://', '')->replaceFirst('http://', '')->value(),
			Str::of($request->headers->get('host'))->replaceFirst('https://', '')->replaceFirst('http://', '')->value()
		];

		$stateful = array_filter(config('sanctum.stateful', []));

		$fromFrontend = collect($domains)->intersect($stateful)->isNotEmpty();

		$request->merge(['from_frontend' => $fromFrontend]);

		return $fromFrontend;
	}
}
