<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetService
{
	public function sendResetLink($credentials)
	{
		return Password::broker()->sendResetLink($credentials);
	}

	public function updatePassword($passwordResetData)
	{
		return Password::broker()->reset(
			$passwordResetData,
			function (User $user) use ($passwordResetData) {
				$user->forceFill([
					'password' => Hash::make($passwordResetData['password'])
				])->save();
				$user->setRememberToken(Str::random(60));
				$user->save();

				event(new PasswordReset($user));
			}
		);
	}
}