<?php

/*
 * This Trait exists because of an edge case scenario that will never actually
 * happen in production, but I was just annoyed by its existence:
 * 1) User Logs in
 * 2) Their account is deleted in the DB while they're logged in
 * 3) User refreshes the page - they're no longer logged in, but their session cookie is still in the browser
 * 4) They create an account - the account is created, but since the invalid cookie still exists
 *    in their browser, they're redirected to the login screen, rather than to their profile
 *
 * This Trait fixes the above scenario by refreshing the session upon registration.
 * */

namespace App\Http\Concerns;

use Illuminate\Http\Request;

trait RefreshesSession
{
	protected function refreshSession(Request $request)
	{
		if ($request->hasSession()) {
			$request->session()->invalidate();
			$request->session()->regenerateToken();
		}
	}
}