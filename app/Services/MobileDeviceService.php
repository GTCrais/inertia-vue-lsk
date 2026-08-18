<?php

namespace App\Services;

use App\Models\MobileDevice;
use App\Models\User;
use Illuminate\Http\Request;

class MobileDeviceService
{
	public function ensureMobileDeviceIsUnique(MobileDevice $mobileDevice)
	{
		MobileDevice::where('device_id', $mobileDevice->device_id)
			->where('id', '!=', $mobileDevice->id)
			->delete();
	}

	public function markAsLoggedIn(Request $request, ?User $user = null)
	{
		$this->mobileDevice($request, $user)?->update(['logged_out_at' => null]);
	}

	public function markAsLoggedOut(Request $request)
	{
		$this->mobileDevice($request)?->update(['logged_out_at' => now()]);
	}

	public function syncLoginState(Request $request)
	{
		if ($request->user()) {
			$this->markAsLoggedIn($request);
		} else {
			$this->markAsLoggedOut($request);
		}
	}

	protected function mobileDevice(Request $request, ?User $user = null)
	{
		$user = $user ?: $request->user();
		$mobileDevice = null;
		$query = MobileDevice::where('device_id', $request->mobileDeviceId());

		if ($user) {
			$mobileDevice = (clone $query)->where('user_id', $user->id)->first();
		}

		return $mobileDevice;
	}
}
