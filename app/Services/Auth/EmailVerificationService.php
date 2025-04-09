<?php

namespace App\Services\Auth;

use App\Http\Requests\Auth\VerifyEmailRequest;
use Illuminate\Auth\Events\Verified;

class EmailVerificationService
{
	public function verify(VerifyEmailRequest $request)
	{
		if (!$request->resolvedUser->hasVerifiedEmail() && $request->resolvedUser->markEmailAsVerified()) {
			event(new Verified($request->resolvedUser));
		}
	}
}