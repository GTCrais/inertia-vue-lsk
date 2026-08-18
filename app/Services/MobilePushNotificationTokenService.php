<?php

namespace App\Services;

use App\Http\Requests\MobilePushNotificationTokenDestroyRequest;
use App\Http\Requests\MobilePushNotificationTokenStoreRequest;
use App\Models\MobileDevice;

class MobilePushNotificationTokenService
{
	public function __construct(
	    protected MobileDeviceService $mobileDeviceService
	) {}

	public function store(MobilePushNotificationTokenStoreRequest $request)
	{
		try {
		    \DB::beginTransaction();

			$mobileDevice = MobileDevice::firstOrCreate(
				['device_id' => $request->mobileDeviceId()]
			);

			$mobileDevice->update([
				'push_notifications_token' => $request->validated('token'),
				'user_id' => $request->user()?->id
			]);

			$this->mobileDeviceService->ensureMobileDeviceIsUnique($mobileDevice);

		    \DB::commit();
		} catch (\Throwable $e) {
		    \DB::rollBack();
		    throw $e;
		}

		return $mobileDevice;
	}

	public function destroy(MobilePushNotificationTokenDestroyRequest $request)
	{
		MobileDevice::where('device_id', $request->mobileDeviceId())
			->update(['push_notifications_token' => null]);
	}
}
