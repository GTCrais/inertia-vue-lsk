<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\NewPasswordStoreRequest;
use App\Services\Auth\PasswordResetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;

class NewPasswordController extends Controller
{
	public function show(Request $request)
	{
		return Inertia::render('auth/NewPassword', [
			'message' => session('newPasswordMessage'),
			'urlEmail' => $request->input('email'),
			'resetToken' => $request->input('token')
		]);
    }

	public function store(NewPasswordStoreRequest $request, PasswordResetService $passwordResetService)
	{
		$status = $passwordResetService->updatePassword($request->validated());
		$redirect = ($status == Password::PASSWORD_RESET)
			? redirect()->route('login.show')
			: back();

		return $redirect->with('newPasswordMessage', trans($status));
	}
}
