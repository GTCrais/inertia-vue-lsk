<?php

namespace App\Http\Concerns;

use Illuminate\Http\RedirectResponse;

trait RedirectsToMobileAppWithError
{
	public function redirectToAppWithError(string $error, string $description): RedirectResponse
	{
		$params = http_build_query([
			'error' => $error,
			'error_description' => $description,
		]);

		return redirect()->away(config('mobile.uriScheme') . "://auth/social/callback?{$params}");
	}
}
