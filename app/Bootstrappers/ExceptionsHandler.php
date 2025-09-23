<?php

namespace App\Bootstrappers;

use App\Services\InertiaHelperService;
use Illuminate\Foundation\Configuration\Exceptions;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ExceptionsHandler
{
	public static function handle(Exceptions $exceptions)
	{
		$exceptions->respond(function (Response $response, Throwable $exception, \Illuminate\Http\Request $request) {
			$inertiaHelperService = app(InertiaHelperService::class);
			$inertiaHelperService->setRootView();
			$inertiaHelperService->shareData($request);

			if (
				(config('app.gracefully_handle_exceptions') || !app()->environment(['local', 'testing'])) &&
				in_array($response->getStatusCode(), [500, 503, 404, 403])
			) {
				return $request->expectsJson()
					? response()->json(['message' => $exception->getMessage()], $response->getStatusCode())
					: Inertia::render('misc/ErrorPage', ['statusCode' => $response->getStatusCode()])
						->toResponse($request)
						->setStatusCode($response->getStatusCode());
			} else if ($response->getStatusCode() === 419) {
				if (collect($request->route()->middleware())->contains('auth:sanctum')) {
					/*
					 * What's this? Well. If you're, for example, just about to click "Update" on your User Account form, but
					 * something happens to distract you, you step away for a while, your session expires, you come back and
					 * finally click that "Update" button, the form will send a PUT request to a Sanctum protected endpoint.
					 * Laravel/Inertia don't know how to handle unauthenticated PUT requests to Sanctum protected endpoints.
					 * And therefore...this little hack, which will use a frontend component to redirect the User to the
					 * Login screen with an appropriate message.
					 */
					if (collect([Request::METHOD_GET, Request::METHOD_POST])->doesntContain($request->method())) {
						return Inertia::render('misc/RedirectSessionExpiredToLogin')
							->toResponse($request)
							->setStatusCode($response->getStatusCode());
					}

					return redirect()->guest(route('login.show'))
						->with('authenticationExpired', true)
						->withErrors(['authenticationExpired' => true]);
				}

				return back()->with('sessionExpired', true)
					->withErrors(['sessionExpired' => true]);
			} else if ($response->getStatusCode() === 429) {
				return $request->expectsJson()
					? response()->json(['message' => $exception->getMessage()], 429)
					: back()->with('tooManyRequests', \Str::random())
						->withErrors(['tooManyRequests' => true]);
			}

			return $request->expectsJson()
				? response()->json(['message' => $exception->getMessage()], $response->getStatusCode())
				: $response;
		});
	}
}