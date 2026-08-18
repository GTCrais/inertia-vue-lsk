<?php

namespace App\Providers;

use App\Listeners\HandleFailedFcmNotification;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Apple\Provider;
use SocialiteProviders\Manager\SocialiteWasCalled;

class AppServiceProvider extends ServiceProvider
{
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
    public function boot(): void
    {
		Event::listen(NotificationFailed::class, HandleFailedFcmNotification::class);
		Event::listen(function (SocialiteWasCalled $event) {
			$event->extendSocialite('apple', Provider::class);
		});

		Relation::enforceMorphMap([
			'user' => User::class
		]);
    }
}
