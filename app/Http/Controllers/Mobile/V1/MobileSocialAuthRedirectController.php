<?php

namespace App\Http\Controllers\Mobile\V1;

use App\Http\Controllers\Controller;
use App\Services\Auth\MobileSocialAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MobileSocialAuthRedirectController extends Controller
{
	public function __construct(
		protected MobileSocialAuthService $mobileSocialAuthService
	) {}

	public function __invoke(Request $request, string $socialNetwork): RedirectResponse
	{
		return $this->mobileSocialAuthService->redirect($request, $socialNetwork);
	}
}
