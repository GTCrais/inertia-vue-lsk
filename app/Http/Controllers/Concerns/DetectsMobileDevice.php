<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;

trait DetectsMobileDevice
{
	protected function isMobileDevice(Request $request): bool
	{
		$userAgent = $request->userAgent() ?? '';

		return preg_match('/android|iphone|ipad|ipod/i', $userAgent) === 1;
	}
}
