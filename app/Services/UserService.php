<?php

namespace App\Services;

use App\Models\User;

class UserService
{
	public function __construct(
	    protected ProfileService $profileService
	) {}

	public function destroy(User $user)
	{
		try {
		    \DB::beginTransaction();

		    $user->notifications()->delete();
			$this->profileService->optionallyDeleteAvatar($user->avatar);
			$user->delete();

		    \DB::commit();
		} catch (\Throwable $e) {
		    \DB::rollBack();
		    throw $e;
		}
	}
}