<?php

namespace App\Http\Controllers\Mobile\V1;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class MobileNotificationController extends Controller
{
	public function __construct(
	    protected NotificationService $notificationService
	) {}

	public function index(Request $request)
	{
		return response()->json(
			$this->notificationService->forNotificationsPage($request->persona(), forMobile: true)
		);
    }
}
