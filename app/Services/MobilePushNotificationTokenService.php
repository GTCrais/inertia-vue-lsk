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
			$mobileDevice = MobileDevice::updateOrCreate(
				['device_id' => $request->mobileDeviceId()],
				[
					'user_id' => $request->user()->id,
					'push_notifications_token' => $request->validated('token'),
					'logged_out_at' => null
				]
			);

			$this->mobileDeviceService->ensureMobileDeviceIsUnique($mobileDevice);

			return $mobileDevice;
		});
	}

	public function destroy(MobilePushNotificationTokenDestroyRequest $request)
	{
		MobileDevice::where('device_id', $request->mobileDeviceId())
			->where('user_id', $request->user()->id)
			->update(['push_notifications_token' => null]);
	}
}
