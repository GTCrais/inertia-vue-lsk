<?php

namespace App\Http\Controllers\Mobile\V1;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class MobileNotificationCountController extends Controller
{
	public function __construct(
	    protected NotificationService $notificationService
	) {}

	public function __invoke(Request $request)
	{
		return response()->json(
			$this->notificationService->unreadNotificationsCount($request->user())
		);
	}
}
