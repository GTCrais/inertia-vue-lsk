<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordResetRequestStoreRequest;
use App\Services\Auth\PasswordResetService;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;

class PasswordResetRequestController extends Controller
{
	public function create()
	{
		return Inertia::render('auth/ForgottenPassword', [
			'message' => session('passwordResetRequestMessage'),
			'success' => session()->has('passwordResetRequestStatus') ? (session('passwordResetRequestStatus') === Password::RESET_LINK_SENT) : null
		]);
    }

	public function store(PasswordResetRequestStoreRequest $request, PasswordResetService $passwordResetService)
	{
		$passwordResetService->sendResetLink($request->only('email'));

		$message = 'If an account with that email address exists, a password reset link has been sent.';

		if ($request->wantsJson()) {
			return response()->json([
				'success' => true,
				'message' => $message
			]);
		}

		return back()->with([
			'passwordResetRequestStatus' => Password::RESET_LINK_SENT,
			'passwordResetRequestMessage' => $message
		]);
	}
}
