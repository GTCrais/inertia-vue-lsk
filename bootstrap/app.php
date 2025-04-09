<?php

use App\Bootstrappers\ExceptionsHandler;
use App\Bootstrappers\MiddlewareRegistrar;
use App\Bootstrappers\RouteRegistrar;
use App\Bootstrappers\ScheduleRegistrar;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
	->withRouting(fn() => RouteRegistrar::register())
	->withMiddleware(fn(Middleware $middleware) => MiddlewareRegistrar::register($middleware))
	->withExceptions(fn(Exceptions $exceptions) => ExceptionsHandler::handle($exceptions))
	->withSchedule(fn(Schedule $schedule) => ScheduleRegistrar::register($schedule))
	->create();
