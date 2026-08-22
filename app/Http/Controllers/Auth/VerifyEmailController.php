<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Concerns\DetectsMobileDevice;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Services\Auth\EmailVerificationService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Inertia\Inertia;

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
			Inertia::flash('verified', true);

			return redirect()->route('user.profile.show');
		}

		$token = Str::random(32);
		Cache::put("email_verified:{$token}", true, now()->addMinutes(5));

		return redirect()->route('email-verified.show', ['token' => $token]);
	}
}
