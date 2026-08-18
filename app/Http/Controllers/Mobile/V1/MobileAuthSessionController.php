<?php

namespace App\Http\Controllers\Mobile\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Concerns\PreparesMobileAuthData;
use App\Services\Auth\AuthService;
use App\Services\MobileDeviceService;
use Illuminate\Http\Request;

class MobileAuthSessionController extends Controller
{
	use PreparesMobileAuthData;

	public function __construct(
	    protected AuthService $authService,
	    protected MobileDeviceService $mobileDeviceService
	) {}

	public function store(LoginRequest $request)
	{
		if (! ($user = $this->authService->login($request))) {
			abort(401, 'Netočni podaci za prijavu');
		}

		$this->mobileDeviceService->markAsLoggedIn($request, $user);

		return response()->json($this->getMobileAuthData($request, $user));
    }

	public function destroy(Request $request)
	{
		$this->mobileDeviceService->markAsLoggedOut($request);
		$this->authService->logout($request);

		return response()->json();
	}
}
