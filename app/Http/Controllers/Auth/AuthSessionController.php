<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthSessionController extends Controller
{
	public function __construct(
		protected AuthService $authService
	) {}

	public function store(LoginRequest $request)
	{
		if (!$this->authService->login($request)) {
			return redirect()->route('login.show')->withErrors([
				'general' => 'Invalid login credentials.',
			]);
		}

		return redirect()->intended(route('pages.show', ['slug' => 'account']));
    }

	public function destroy(Request $request)
	{
		$this->authService->logout($request);

		Inertia::clearHistory();

		return redirect()->route('pages.show');
	}
}
