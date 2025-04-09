<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Services\Auth\EmailVerificationService;

class VerifyEmailController extends Controller
{
	public function __invoke(VerifyEmailRequest $request, EmailVerificationService $emailVerificationService)
	{
		$emailVerificationService->verify($request);

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
