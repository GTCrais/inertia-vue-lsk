<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestType
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, $requiredRequestType): Response
    {
		if (($requiredRequestType == 'stateless') && !$request->stateless()) {
			abort(404);
		}

		if (($requiredRequestType == 'mobileApp') && !$request->mobileApp()) {
			abort(404);
		}

        return $next($request);
    }
}
