<?php

namespace App\Http\Controllers\Mobile\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\MobileSocialAuthCallbackRequest;
use App\Services\Auth\MobileSocialAuthService;
use Illuminate\Http\RedirectResponse;

class MobileSocialAuthCallbackController extends Controller
{
	public function __construct(
		protected MobileSocialAuthService $mobileSocialAuthService
	) {}

	public function __invoke(MobileSocialAuthCallbackRequest $request, string $socialNetwork): RedirectResponse
	{
		return $this->mobileSocialAuthService->callback($request, $socialNetwork);
	}
}
