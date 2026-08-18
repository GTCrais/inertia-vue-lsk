<?php

namespace App\Providers;

use App\Http\Middleware\SanctumMiddleware;
use App\Services\ViewMetadataProviderService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class StarterKitServiceProvider extends ServiceProvider
{
	public $singletons = [
		ViewMetadataProviderService::class => ViewMetadataProviderService::class
	];

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
			return $this->header(config('mobile.deviceIdHeader'));
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
    public function boot(ViewMetadataProviderService $viewMetadataProviderService): void
    {
		View::share('metadataProvider', $viewMetadataProviderService);
		View::share('facebookAppId', config('services.facebook.client_id'));

		JsonResource::withoutWrapping();
		ResourceCollection::withoutWrapping();
    }
}
