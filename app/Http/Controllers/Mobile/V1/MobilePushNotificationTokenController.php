<?php

namespace App\Http\Controllers\Mobile\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\MobilePushNotificationTokenDestroyRequest;
use App\Http\Requests\MobilePushNotificationTokenStoreRequest;
use App\Services\MobilePushNotificationTokenService;

class MobilePushNotificationTokenController extends Controller
{
	public function __construct(
	    protected MobilePushNotificationTokenService $mobilePushNotificationTokenService
	) {}

	public function store(MobilePushNotificationTokenStoreRequest $request)
	{
		$mobileDevice = $this->mobilePushNotificationTokenService->store($request);

		return response()->json($mobileDevice);
	}

	public function destroy(MobilePushNotificationTokenDestroyRequest $request)
	{
		$this->mobilePushNotificationTokenService->destroy($request);

		return response()->json();
	}
}
