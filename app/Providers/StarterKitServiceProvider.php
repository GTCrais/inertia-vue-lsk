<?php

namespace App\Providers;

use App\Http\Middleware\SanctumMiddleware;
use App\Models\User;
use App\Notifications\ResetPassword;
use App\Services\ViewMetadataProviderService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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

		Relation::enforceMorphMap([
			'user' => User::class
		]);

		RateLimiter::for('login', function (Request $request) {
			$throttleKey = Str::transliterate(Str::lower($request->input('email')) . '_' . $request->ip());

			return Limit::perMinute(5)->by($throttleKey);
		});

		RateLimiter::for('register', function (Request $request) {
			return Limit::perMinute(5)->by($request->ip() . '_register');
		});

		RateLimiter::for('passwordReset', function (Request $request) {
			return Limit::perMinute(3)->by($request->ip() . '_password_reset');
		});

		RateLimiter::for('emailVerification', function (Request $request) {
			return Limit::perMinute(6)->by($request->ip() . '_email_verification');
		});
    }
}
