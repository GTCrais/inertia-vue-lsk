<?php

namespace App\Http\Controllers\Mobile\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisteredUserStoreRequest;
use App\Models\Concerns\PreparesMobileAuthData;
use App\Services\Auth\AuthService;
use App\Services\MobileDeviceService;

class MobileRegisteredUserController extends Controller
{
	use PreparesMobileAuthData;

	public function __construct(
	    protected AuthService $authService,
	    protected MobileDeviceService $mobileDeviceService
	) {}

	public function store(RegisteredUserStoreRequest $request)
	{
		$user = $this->authService->register($request);

		$this->mobileDeviceService->markAsLoggedIn($request, $user);

		return response()->json($this->getMobileAuthData($request, $user));
	}
}
