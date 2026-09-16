<?php

namespace App\Bootstrappers;

use App\Services\Auth\AuthService;
use Illuminate\Console\Scheduling\Schedule;

class ScheduleRegistrar
{
	public static function register(Schedule $schedule)
	{
		// $schedule->command('horizon:snapshot')->everyFiveMinutes();
		$schedule->command('sanctum:prune-expired --hours=24')->daily();
		$schedule->command('queue:prune-failed --hours=168')->daily();
		$schedule->call(fn () => resolve(AuthService::class)->pruneInactiveTokens())->name('prune-inactive-tokens')->daily();
	}
}
