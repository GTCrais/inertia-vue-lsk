<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as LaravelResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPassword extends LaravelResetPassword implements ShouldQueue
{
	use Queueable;

	public $tries = 3;
	public $retryAfter = 120;
	public $timeout = (2 * 60); // 2 minutes
	public $failOnTimeout = true;

	/**
	 * Get the mail representation of the notification.
	 */
	public function toMail($notifiable)
	{
		return new \App\Mail\ResetPassword()
			->to($notifiable->email)
			->with(['resetLink' => $this->resetUrl($notifiable)]);
	}

	protected function resetUrl($notifiable)
	{
		if (static::$createUrlCallback) {
			return call_user_func(static::$createUrlCallback, $notifiable, $this->token);
		}

		return url(route('new-password.show', [
			'token' => $this->token,
			'email' => $notifiable->getEmailForPasswordReset(),
		], false));
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
