<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/*
 * Why this class? Well, if you have a newsletter or a contact form, you probably want to throttle users from spamming
 * through these forms. However, if a user submits the form and the request is not successful (they didn't enter
 * their email, for example), then that request shouldn't count towards the rate limit.
 */
class ThrottleSuccessfulRequests extends ThrottleRequests
{
	protected function handleRequest($request, Closure $next, array $limits)
	{
		foreach ($limits as $limit) {
			if ($this->limiter->tooManyAttempts($limit->key, $limit->maxAttempts)) {
				throw $this->buildException($request, $limit->key, $limit->maxAttempts, $limit->responseCallback);
			}
		}

		/** @var Response|RedirectResponse $response */
		$response = $next($request);
		$requestIsSuccessful = $this->responseIsSuccessful($response);

		/** @var Limit $limit */
		foreach ($limits as $limit) {
			if ($requestIsSuccessful) {
				$this->limiter->hit($limit->key, $limit->decaySeconds);
			}

			$response = $this->addHeaders(
				$response,
				$limit->maxAttempts,
				$this->calculateRemainingAttempts($limit->key, $limit->maxAttempts)
			);
		}

		return $response;
	}

	protected function responseIsSuccessful(Response|RedirectResponse $response)
	{
		if (property_exists($response, 'exception') && $response->exception) {
			return false;
		}

		return in_array($response->getStatusCode(), [SymfonyResponse::HTTP_OK, SymfonyResponse::HTTP_FOUND]);
	}
}
