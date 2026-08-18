<?php

namespace App\Http\Controllers\Mobile\V1;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class MobileAppDataController extends Controller
{
	public function __construct(
		protected NotificationService $notificationService
	) {}

    public function __invoke(Request $request)
	{
		$data = [
			'unreadNotificationCount' => $this->notificationService->unreadNotificationsCount($request->user())
		];

		return response()->json($data);
	}
}
