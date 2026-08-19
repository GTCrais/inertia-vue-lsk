<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InertiaHelperService
{
	public function __construct(
	    protected ViewMetadataProviderService $viewMetadataProviderService,
		protected NotificationService $notificationService
	) {}

	public function getShareData(Request $request): array
	{
		return [
			'user' => $request->user() ? UserResource::make($request->user()) : null,
			// We're using "fn()" here because we want the "toArray()" method to resolve just before the Response
			// is sent back to the User, rather than resolving before metadata is actually updated
			'metadata' => fn() => $this->viewMetadataProviderService->toArray(),
			// Deferred: fetched by the client in an automatic follow-up request after the page renders
			'unreadNotificationCount' => Inertia::defer(
				fn() => $this->notificationService->unreadNotificationsCount($request->user())
			)
		];
	}
}
