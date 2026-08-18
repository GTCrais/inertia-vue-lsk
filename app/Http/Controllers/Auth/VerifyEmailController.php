<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Concerns\DetectsMobileDevice;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Services\Auth\EmailVerificationService;

class VerifyEmailController extends Controller
{
	use DetectsMobileDevice;

	public function __invoke(VerifyEmailRequest $request, EmailVerificationService $emailVerificationService)
	{
		$emailVerificationService->verify($request);

		if ($this->isMobileDevice($request) && $request->query('mobile')) {
			return view('auth.mobile-redirect', [
				'appUrl' => config('mobile.uriScheme') . '://email-verified',
				'fallbackUrl' => config('app.url')
			]);
		}

		if ($request->wantsJson()) {
			return response()->json([], 204);
		}

		if ($request->user()) {
			return redirect()->intended('/account?verified=1');
		}

		session()->flash('emailVerified');
		session()->flash('requestType', $request->requestType);

		return redirect()->route('email-verified.show');
	}
}
