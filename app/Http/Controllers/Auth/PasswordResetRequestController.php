<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordResetRequestStoreRequest;
use App\Services\Auth\PasswordResetService;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;

class PasswordResetRequestController extends Controller
{
	public function show()
	{
		return Inertia::render('auth/ForgottenPassword', [
			'message' => session('passwordResetRequestMessage'),
			'success' => session()->has('passwordResetRequestStatus') ? (session('passwordResetRequestStatus') === Password::RESET_LINK_SENT) : null
		]);
    }

	public function store(PasswordResetRequestStoreRequest $request, PasswordResetService $passwordResetService)
	{
		$status = $passwordResetService->sendResetLink($request->only('email'));

		return back()->with([
			'passwordResetRequestStatus' => $status,
			'passwordResetRequestMessage' => trans($status)
		]);
	}
}
