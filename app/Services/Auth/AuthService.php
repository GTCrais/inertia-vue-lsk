<?php

namespace App\Services\Auth;

use App\Http\Concerns\RefreshesSession;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisteredUserStoreRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class AuthService
{
	use RefreshesSession;

	public function login(LoginRequest $request)
	{
		if (auth()->guard('web')->attempt($request->only('email', 'password'), remember: true)) {
			\RateLimiter::clear('login');
		}

		return (auth()->guard('web')->user() ?? null);
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

	public function register(RegisteredUserStoreRequest $request)
	{
		$this->refreshSession($request);

		try {
			\DB::beginTransaction();

			$user = User::create($request->validated());

			\DB::commit();
		} catch (\Throwable $e) {
			\DB::rollBack();
			throw $e;
		}

		event(new Registered($user));

		auth()->guard('web')->login($user, remember: true);

		return $user;
	}
}