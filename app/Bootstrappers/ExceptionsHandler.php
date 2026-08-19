<?php

namespace App\Bootstrappers;

use Illuminate\Foundation\Configuration\Exceptions;
use Inertia\ExceptionResponse;
use Inertia\Inertia;

class ExceptionsHandler
{
	public static function handle(Exceptions $exceptions)
	{
		Inertia::handleExceptionsUsing(function (ExceptionResponse $exceptionResponse) {
			$request = $exceptionResponse->request;
			$statusCode = $exceptionResponse->statusCode();

			if (!$request->inertia()) {
				return null;
			}

			if ($statusCode === 419) {
				if (collect($request->route()?->middleware())->contains('auth:sanctum')) {
					Inertia::flash('authenticationExpired', true);

					return redirect()->guest(route('login.show'));
				}

				Inertia::flash('sessionExpired', true);

				return back();
			}

			if ($statusCode === 429) {
				Inertia::flash('tooManyRequests', true);

				return back();
			}

			if ($statusCode >= 400 && static::shouldRenderErrorPage()) {
				return $exceptionResponse->render('misc/ErrorPage', ['statusCode' => $statusCode])
					->withSharedData();
			}

			return null;
		});
	}

	protected static function shouldRenderErrorPage(): bool
	{
		return config('app.gracefully_handle_exceptions') || !app()->environment(['local', 'testing']);
	}
}
