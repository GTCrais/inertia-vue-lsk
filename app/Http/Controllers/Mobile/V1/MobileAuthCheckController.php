<?php

namespace App\Http\Controllers\Mobile\V1;

use App\Http\Controllers\Controller;
use App\Models\Concerns\PreparesMobileAuthData;
use App\Services\MobileDeviceService;
use Illuminate\Http\Request;

class MobileAuthCheckController extends Controller
{
	use PreparesMobileAuthData;

	public function __construct(
		protected MobileDeviceService $mobileDeviceService
	) {}

    public function __invoke(Request $request)
	{
		$this->mobileDeviceService->syncLoginState($request);

		return response()->json(
			$this->getMobileAuthData($request)
		);
	}
}
