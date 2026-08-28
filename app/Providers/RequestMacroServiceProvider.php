<?php

namespace App\Providers;

use App\Http\Middleware\SanctumMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class RequestMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
	 *
	 * @see SanctumMiddleware::fromFrontend
     */
    public function register(): void
    {
		Request::macro('stateful', function() {
			return $this->from_frontend;
		});

		Request::macro('stateless', function() {
			return !$this->from_frontend;
		});

		Request::macro('mobileDeviceId', function() {
			$header = config('mobile.deviceIdHeader');

			return $header ? $this->header($header) : null;
		});

		Request::macro('mobileApp', function() {
			if ($this->from_frontend) {
				return false;
			}

			if ($this->hasHeader(config('mobile.header'))) {
				return true;
			}

			// Preflight requests (OPTIONS): header is declared here instead
			$acrHeaders = strtolower((string) $this->headers->get('Access-Control-Request-Headers', ''));

			return str_contains($acrHeaders, strtolower(config('mobile.header')));
		});
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
	{

    }
}
