<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisteredUserStoreRequest;
use App\Services\Auth\AuthService;

class RegisteredUserController extends Controller
{
	public function store(RegisteredUserStoreRequest $request, AuthService $authService)
	{
		$authService->register($request);

		return redirect()->route('user-account.show');
    }
}
