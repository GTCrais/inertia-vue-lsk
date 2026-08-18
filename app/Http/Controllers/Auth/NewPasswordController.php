<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Concerns\DetectsMobileDevice;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\NewPasswordStoreRequest;
use App\Services\Auth\PasswordResetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;

class NewPasswordController extends Controller
{
	use DetectsMobileDevice;

	public function create(Request $request)
	{
		if ($this->isMobileDevice($request) && $request->query('mobile')) {
			$fallbackUrl = $request->fullUrlWithoutQuery('mobile');

			return view('auth.mobile-redirect', [
				'appUrl' => config('mobile.uriScheme') . '://new-password?' . http_build_query($request->except('mobile')),
				'fallbackUrl' => $fallbackUrl,
			]);
		}

		return Inertia::render('auth/NewPassword', [
			'message' => session('newPasswordMessage'),
			'urlEmail' => $request->input('email'),
			'resetToken' => $request->input('token')
		]);
    }

	public function store(NewPasswordStoreRequest $request, PasswordResetService $passwordResetService)
	{
		$status = $passwordResetService->updatePassword($request->validated());

		if ($request->wantsJson()) {
			return response()->json([
				'success' => ($status === Password::PASSWORD_RESET),
				'message' => trans($status)
			]);
		}

		$redirect = ($status == Password::PASSWORD_RESET)
			? redirect()->route('login.show')
			: back();

		return $redirect->with('newPasswordMessage', trans($status));
	}
}
