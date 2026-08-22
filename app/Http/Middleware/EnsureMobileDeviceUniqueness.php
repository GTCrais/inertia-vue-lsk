<?php

namespace App\Http\Middleware;

use App\Models\MobileDevice;
use App\Services\MobileDeviceService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMobileDeviceUniqueness
{
	public function handle(Request $request, Closure $next): Response
	{
		$response = $next($request);
		$mobileDevice = null;

		if ($mobileDeviceId = $request->mobileDeviceId()) {
			$query = MobileDevice::query()->where('device_id', $mobileDeviceId)->orderByDesc('id');

			if ($request->user()) {
				$mobileDevice = $query->where('user_id', $request->user()->id)->first();
			}
		}

		if ($mobileDevice) {
			resolve(MobileDeviceService::class)->ensureMobileDeviceIsUnique($mobileDevice);
		}

		return $response;
	}
}
