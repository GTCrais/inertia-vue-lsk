<?php

namespace App\Services\Auth;

use App\Http\Concerns\RefreshesSession;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisteredUserStoreRequest;
use App\Models\User;
use App\Services\RateLimiterService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Sanctum\PersonalAccessToken;

class AuthService
{
	use RefreshesSession;

	public function __construct(
	    protected RateLimiterService $rateLimiterService
	) {}

	public function login(LoginRequest $request)
	{
		if (auth()->guard('web')->attempt($request->only('email', 'password'), remember: true)) {
			RateLimiter::clear(
				$this->rateLimiterService->loginKey($request, named: true, optionallyHashed: true)
			);

			if ($request->hasSession()) {
				$request->session()->regenerate();
			}
		}

		return auth()->guard('web')->user() ?? null;
	}

	public function logout(Request $request)
	{
		$user = $request->user();

		if ($request->stateful()) {
			auth()->guard('web')->logout();
			$this->refreshSession($request);
		} else {
			$user->currentAccessToken()->delete();
		}
	}

	public function pruneInactiveTokens()
	{
		$cutoff = now()->subDays(config('mobile.authTokenMaxInactivityDays'));

		PersonalAccessToken::query()
			->where(fn ($query) => $query
				->where('last_used_at', '<', $cutoff)
				->orWhere(fn ($neverUsed) => $neverUsed->whereNull('last_used_at')->where('created_at', '<', $cutoff))
			)
			->delete();
	}

	public function register(RegisteredUserStoreRequest $request)
	{
		$this->refreshSession($request);

		$user = DB::transaction(fn () => User::create($request->validated()));

		event(new Registered($user));

		auth()->guard('web')->login($user, remember: true);

		return $user;
	}
}
