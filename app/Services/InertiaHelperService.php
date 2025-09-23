<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InertiaHelperService
{
	public static $rootView = 'default';

	public function __construct(
	    protected ViewMetadataProviderService $viewMetadataProviderService
	) {}

	public function setRootView()
	{
		Inertia::setRootView(static::$rootView);
	}

	public function shareData(Request $request)
	{
		foreach ($this->getShareData($request) as $key => $value ) {
			Inertia::share($key, $value);
		}
	}

	public function getShareData(Request $request): array
	{
		return [
			'user' => $request->user() ? UserResource::make($request->user()) : null,
			// We're using "fn()" here because we want the "toArray()" method to resolve just before the Response
			// is sent back to the User, rather than resolving before metadata is actually updated
			'metadata' => fn() => $this->viewMetadataProviderService->toArray(),
			'sessionExpired' => session('sessionExpired'),
			'tooManyRequests' => session('tooManyRequests')
		];
	}
}