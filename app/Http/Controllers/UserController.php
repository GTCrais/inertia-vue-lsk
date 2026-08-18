<?php

namespace App\Http\Controllers;

use App\Http\Concerns\RefreshesSession;
use App\Services\Auth\AuthService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
	use RefreshesSession;

	public function __construct(
	    private AuthService $authService
	) {}

	public function destroy(Request $request, UserService $userService)
	{
		$user = $request->user();
		$this->authService->logout($request);
		$userService->destroy($user);

		if ($request->wantsJson()) {
			return response()->json();
		}

		return redirect()->to('/');
    }
}
