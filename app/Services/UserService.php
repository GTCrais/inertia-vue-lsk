<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
	public function __construct(
	    protected ProfileService $profileService
	) {}

	public function destroy(User $user)
	{
		DB::transaction(function () use ($user) {
			$user->notifications()->delete();
			$this->profileService->optionallyDeleteAvatar($user->avatar);
			$user->delete();
		});
	}
}
