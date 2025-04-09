<?php

namespace App\Http\Middleware;

use App\Http\Resources\UserResource;
use App\Services\ViewMetadataProviderService;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
	public function __construct(
		protected ViewMetadataProviderService $viewMetadataProviderService
	) {}

    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'default';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
			'user' => $request->user() ? UserResource::make($request->user()) : null,
			// We're using "fn()" here because we want the "toArray()" method to resolve just before the Response
			// is sent back to the User, rather than resolving before metadata is actually updated
			'metadata' => fn() => $this->viewMetadataProviderService->toArray(),
			'sessionExpired' => session('sessionExpired'),
			'tooManyRequests' => session('tooManyRequests')
        ]);
    }
}
