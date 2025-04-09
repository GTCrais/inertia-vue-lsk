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
		if ($success = auth()->guard('web')->attempt($request->only('email', 'password'))) {
			\RateLimiter::clear('login');
		}

		return $success;
	}

	public function logout(Request $request)
	{
		auth()->guard('web')->logout();

		if ($request->hasSession()) {
			$request->session()->invalidate();
			$request->session()->regenerateToken();
		}
	}

	public function register(RegisteredUserStoreRequest $request)
	{
		$this->refreshSession($request);

		event(new Registered($user = User::create($request->validated())));

		auth()->guard('web')->login($user);
	}
}