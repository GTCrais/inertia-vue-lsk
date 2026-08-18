<?php

namespace App\Http\Helpers;

use Inertia\Inertia;

class AppResponse
{
	public static function make(string $component, $props = [])
	{
		if (request()->stateful()) {
			return Inertia::render($component, $props);
		}

		return response()->json($props);
	}
}