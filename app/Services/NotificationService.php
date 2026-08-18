<?php

namespace App\Services;

use App\Http\Resources\NotificationResource;
use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Pagination\LengthAwarePaginator;
use function Illuminate\Support\defer;

class NotificationService
{
	public function forNotificationsPage(null|User $user, $forMobile = false)
	{
		$user = $user ?: new User;

		/** @var LengthAwarePaginator $notifications */
		$notifications = $user->notifications()
			->where('created_at', '>=', now()->subWeeks(4))
			->paginate(20);

		defer(fn() => DatabaseNotification::whereKey($notifications->pluck('id'))->update(['read_at' => now()]));

		$unreadNotifications = $notifications->filter(fn(DatabaseNotification $notification) => $notification->unread());

		if ($forMobile) {
			return [
				'paginator' => $notifications->through(fn($notification) => NotificationResource::make($notification)),
				'unreadNotificationCount' => $this->unreadNotificationsCount($user, $unreadNotifications->count())
			];
		}

		return NotificationResource::collection($notifications)
			->additional(['unreadNotificationCount' => $this->unreadNotificationsCount($user, $unreadNotifications->count())]);
	}

	public function unreadNotificationsCount(null|User $user, $subtract = 0)
	{
		return max(0, ($user?->unreadNotifications()->where('created_at', '>=', now()->subWeeks(4))->count() ?? 0) - $subtract);
	}
}