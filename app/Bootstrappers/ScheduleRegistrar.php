<?php

namespace App\Bootstrappers;

use Illuminate\Console\Scheduling\Schedule;

class ScheduleRegistrar
{
	public static function register(Schedule $schedule)
	{
		$schedule->command('horizon:snapshot')->everyFiveMinutes();
	}
}