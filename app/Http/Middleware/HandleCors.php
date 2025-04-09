<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Illuminate\Http\Middleware\HandleCors as BaseHandleCors;
use Symfony\Component\HttpFoundation\Response;

class HandleCors extends BaseHandleCors
{
	/**
	 * Handle the incoming request.
	 *
	 * @param Request $request
	 * @param \Closure $next
	 *
	 * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	public function handle($request, Closure $next)
	{
		if (! $this->hasMatchingPath($request)) {
			return $next($request);
		}

		$this->cors->setOptions($this->container['config']->get('cors', []));

		if ($this->cors->isPreflightRequest($request)) {
			$response = new Response();

			$response->setStatusCode(204);

			if ($request->stateless()) {
				$response->headers->set('Access-Control-Allow-Origin', (string) $request->headers->get('Origin'));
			}

			$response = $this->cors->addPreflightRequestHeaders($response, $request);

			$this->cors->varyHeader($response, 'Access-Control-Request-Method');

			return $response;
		}

		$response = $next($request);

		if ($request->getMethod() === 'OPTIONS') {
			$this->cors->varyHeader($response, 'Access-Control-Request-Method');
		}

		// Fix for mobile app
		if ($request->stateless()) {
			$response->headers->set('Access-Control-Allow-Origin', (string) $request->headers->get('Origin'));
		}

		return $this->cors->addActualRequestHeaders($response, $request);
	}
}
