<?php

namespace App\Services;

use App\Http\Requests\MobilePushNotificationTokenDestroyRequest;
use App\Http\Requests\MobilePushNotificationTokenStoreRequest;
use App\Models\MobileDevice;
use Illuminate\Support\Facades\DB;

class MobilePushNotificationTokenService
{
	public function __construct(
	    protected MobileDeviceService $mobileDeviceService
	) {}

	public function store(MobilePushNotificationTokenStoreRequest $request)
	{
		return DB::transaction(function () use ($request) {
			$mobileDevice = MobileDevice::firstOrCreate(
				['device_id' => $request->mobileDeviceId()]
			);

			$mobileDevice->update([
				'push_notifications_token' => $request->validated('token'),
				'user_id' => $request->user()?->id
			]);

			$this->mobileDeviceService->ensureMobileDeviceIsUnique($mobileDevice);

			return $mobileDevice;
		});
	}

	public function destroy(MobilePushNotificationTokenDestroyRequest $request)
	{
		MobileDevice::where('device_id', $request->mobileDeviceId())
			->update(['push_notifications_token' => null]);
	}
}
