<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as LaravelVerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends LaravelVerifyEmail implements ShouldQueue
{
	use Queueable;

	public $tries = 3;
	public $retryAfter = 120;
	public $timeout = (2 * 60); // 2 minutes
	public $failOnTimeout = true;

	public function __construct(
		public bool $mobile = false
	) {}

	/**
	 * Get the mail representation of the notification.
	 */
	public function toMail($notifiable)
	{
		return new \App\Mail\VerifyEmail()
			->to($notifiable->email)
			->with(['verificationLink' => $this->verificationUrl($notifiable)]);
	}

	/**
	 * Get the verification URL for the given notifiable.
	 *
	 * @param mixed $notifiable
	 * @return string
	 */
	protected function verificationUrl($notifiable)
	{
		if (static::$createUrlCallback) {
			return call_user_func(static::$createUrlCallback, $notifiable);
		}

		$expireMinutes = Config::get('auth.verification.expire');
		$params = [
			'id' => $notifiable->getKey(),
			'hash' => sha1($notifiable->getEmailForVerification()),
		];

		if ($this->mobile) {
			$params['mobile'] = 1;
		}

		return URL::temporarySignedRoute(
			'verify-email.show',
			Carbon::now()->addMinutes($expireMinutes),
			$params,
		);
	}

	public function viaQueues(): array
	{
		return [
			'mail' => config('queue.map.mail')
		];
	}

	public function backoff(): array
	{
		return [30, 60];
	}
}
