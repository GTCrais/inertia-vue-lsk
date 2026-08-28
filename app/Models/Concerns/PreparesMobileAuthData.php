<?php

namespace App\Models\Concerns;

use App\Models\MobileDevice;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

trait PreparesMobileAuthData
{
	protected function getMobileAuthData(Request $request, ?User $user = null)
	{
		$user = ($user ?: $request->user());

		return [
			'user' => $user ? $this->setAccessToken($user, $request)->prepareUser($request, $user) : null,
			'unreadNotificationCount' => resolve(NotificationService::class)->unreadNotificationsCount($user),
		];
	}

	protected function prepareUser(Request $request, User $user)
	{
		$user->setAttribute(
			'has_valid_push_notification_token',
			MobileDevice::query()
				->where('device_id', $request->mobileDeviceId())
				->where('user_id', $user->id)
				->whereNotNull('push_notifications_token')
				->exists()
		);

		return $user;
	}

	protected function setAccessToken(User $user, Request $request)
	{
		$deviceId = $request->mobileDeviceId();

		if (!is_string($deviceId) || $deviceId === '' || strlen($deviceId) > 255) {
			abort(422, 'A valid device id header is required.');
		}

		$currentToken = $user->currentAccessToken();
		$rotationThreshold = now()->subDays(config('mobile.authTokenRotationDays'));

		if ($currentToken instanceof PersonalAccessToken && $currentToken->created_at->gt($rotationThreshold)) {
			return $this;
		}

		$newToken = $user->createToken($deviceId);

		if ($currentToken instanceof PersonalAccessToken) {
			$graceEnd = now()->addMinutes(config('mobile.authTokenRotationGraceMinutes'));

			if (!$currentToken->expires_at || $currentToken->expires_at->gt($graceEnd)) {
				$currentToken->update(['expires_at' => $graceEnd]);
			}
		}

		$user->tokens()
			->where('name', $deviceId)
			->whereKeyNot($newToken->accessToken->getKey())
			->when($currentToken instanceof PersonalAccessToken, fn ($query) => $query->whereKeyNot($currentToken->getKey()))
			->delete();

		$user->withAccessToken($newToken->accessToken);
		$user->setAttribute('plain_text_token', $newToken->plainTextToken);

		return $this;
	}
}
