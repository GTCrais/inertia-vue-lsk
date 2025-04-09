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
		protected bool $stateless
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

		return URL::temporarySignedRoute(
			'verify-email.show',
			Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
			[
				'id' => $notifiable->getKey(),
				'requestType' => $this->stateless ? 'stateless' : 'stateful',
				'hash' => sha1($notifiable->getEmailForVerification()),
			]
		);
	}

	public function viaQueues(): array
	{
		return [
			'mail' => 'mail'
		];
	}

	public function backoff(): array
	{
		return [30, 60];
	}
}
