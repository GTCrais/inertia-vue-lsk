<?php

namespace App\Services;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class RateLimiterService
{
	protected static $shouldHashKeys = true;

	public function loginKey(Request $request, $named = false, $optionallyHashed = false)
	{
		$key = Str::transliterate(Str::lower($request->input('email')) . '_' . $request->ip());

		if (!$named) {
			return $key;
		}

		return ($optionallyHashed && static::$shouldHashKeys)
			? md5('login' . $key)
			: 'login:' . $key;
	}

	public function registerLimiters()
	{
		ThrottleRequests::shouldHashKeys(static::$shouldHashKeys);

		RateLimiter::for('login', function (Request $request) {
			return Limit::perMinute(5)->by($this->loginKey($request));
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

		RateLimiter::for('newPassword', function (Request $request) {
			return Limit::perMinute(6)->by($request->ip() . '_new_password');
		});

		RateLimiter::for('socialTokenExchange', function (Request $request) {
			return Limit::perMinute(10)->by($request->ip() . '_social_token_exchange');
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
			return Limit::perMinute(10)->by($request->user()->id . '_push_notifications_token_store');
		});

		RateLimiter::for('pushNotificationsTokenDestroy', function (Request $request) {
			return Limit::perMinute(6)->by($request->user()->id . '_push_notifications_token_destroy');
		});
	}
}
