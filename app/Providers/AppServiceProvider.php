<?php

namespace App\Providers;

use App\Listeners\HandleFailedFcmNotification;
use App\Models\User;
use App\Services\RateLimiterService;
use App\Services\ViewMetadataProviderService;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Apple\Provider;
use SocialiteProviders\Manager\SocialiteWasCalled;

class AppServiceProvider extends ServiceProvider
{
	public $singletons = [
		ViewMetadataProviderService::class => ViewMetadataProviderService::class
	];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(
		RateLimiterService $rateLimiterService,
		ViewMetadataProviderService $viewMetadataProviderService
	): void {
		$rateLimiterService->registerLimiters();

		Event::listen(NotificationFailed::class, HandleFailedFcmNotification::class);
		Event::listen(function (SocialiteWasCalled $event) {
			$event->extendSocialite('apple', Provider::class);
		});

		Relation::enforceMorphMap([
			'user' => User::class
		]);

		View::share('metadataProvider', $viewMetadataProviderService);
		View::share('facebookAppId', config('services.facebook.client_id'));

		JsonResource::withoutWrapping();
		ResourceCollection::withoutWrapping();
    }
}
