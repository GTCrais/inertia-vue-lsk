<?php

namespace App\Listeners;

use App\Models\MobileDevice;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Kreait\Firebase\Exception\Messaging\QuotaExceeded;
use Kreait\Firebase\Exception\Messaging\ServerError;
use Kreait\Firebase\Exception\Messaging\ServerUnavailable;
use Kreait\Firebase\Messaging\SendReport;
use NotificationChannels\Fcm\FcmChannel;

class HandleFailedFcmNotification
{
	protected const MAX_RETRIES = 3;

	public function handle(NotificationFailed $event): void
	{
		if ($event->channel !== FcmChannel::class) {
			return;
		}

		/** @var SendReport $report */
		$report = Arr::get($event->data, 'report');

		if (!$report) {
			return;
		}

		if ($report->messageTargetWasInvalid() || $report->messageWasSentToUnknownToken()) {
			$this->clearToken($report);

			return;
		}

		$error = $report->error();

		if ($error instanceof QuotaExceeded) {
			$this->retry($event, delayMinutes: 5);

			return;
		}

		if ($error instanceof ServerUnavailable || $error instanceof ServerError) {
			$this->retry($event, delayMinutes: 1);
		}
	}

	protected function retry(NotificationFailed $event, int $delayMinutes): void
	{
		$key = "fcm_retries:{$event->notification->id}";

		Cache::add($key, 0, now()->addHours(2));

		if (Cache::increment($key) > static::MAX_RETRIES) {
			return;
		}

		$event->notifiable->notify(
			(clone $event->notification)->delay(now()->addMinutes($delayMinutes))
		);
	}

	protected function clearToken(SendReport $report): void
	{
		$token = $report->target()->value();

		MobileDevice::where('push_notifications_token', $token)
			->update(['push_notifications_token' => null]);
	}
}
