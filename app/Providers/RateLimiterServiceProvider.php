<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class RateLimiterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
		RateLimiter::for('login', function (Request $request) {
			$throttleKey = Str::transliterate(Str::lower($request->input('email')) . '_' . $request->ip());

			return Limit::perMinute(5)->by($throttleKey);
		});

		RateLimiter::for('socialLogin', function (Request $request) {
			return Limit::perMinute(10)->by($request->ip() . '_social_login');
		});

		RateLimiter::for('register', function (Request $request) {
			return Limit::perMinute(5)->by($request->ip() . '_register');
		});

		RateLimiter::for('passwordReset', function (Request $request) {
			return Limit::perMinute(3)->by($request->ip() . '_password_reset');
		});

		RateLimiter::for('emailVerificationNotification', function (Request $request) {
			return Limit::perMinute(2)->by($request->user()->id . '_email_verification_notification');
		});

		RateLimiter::for('emailVerification', function (Request $request) {
			return Limit::perMinute(6)->by($request->ip() . '_email_verification');
		});

		RateLimiter::for('profileUpdate', function (Request $request) {
			return Limit::perMinute(15)->by($request->user()->id . '_profile_update');
		});

		RateLimiter::for('passwordUpdate', function (Request $request) {
			return Limit::perMinute(6)->by($request->user()->id . '_password_update');
		});

		RateLimiter::for('pushNotificationsTokenStore', function (Request $request) {
			return Limit::perMinute(10)->by($request->mobileDeviceId() . '_' . $request->ip() . '_push_notifications_token_store');
		});

		RateLimiter::for('pushNotificationsTokenDestroy', function (Request $request) {
			return Limit::perMinute(6)->by($request->mobileDeviceId() . '_' . $request->ip() . '_push_notifications_token_destroy');
		});
    }
}
