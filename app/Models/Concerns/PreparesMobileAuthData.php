<?php

namespace App\Models\Concerns;

use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;

trait PreparesMobileAuthData
{
	protected function getMobileAuthData(Request $request, ?User $user = null)
	{
		$user = ($user ?: $request->user());

		return [
			'user' => $user ? $this->setAccessToken($user)->prepareUser($user) : null,
			'unreadNotificationCount' => resolve(NotificationService::class)->unreadNotificationsCount($user),
		];
	}

	protected function prepareUser(User $user)
	{
		$user->append('has_valid_push_notification_token');

		return $user;
	}

	protected function setAccessToken(User $user)
	{
		$newToken = $user->createToken('AUTH_TOKEN');

		$user->withAccessToken($newToken->accessToken);
		$user->setAttribute('plain_text_token', $newToken->plainTextToken);

		return $this;
	}
}