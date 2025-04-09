<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoginPageController extends Controller
{
	public function show(Request $request)
	{
		if ($request->has('authenticationExpired')) {
			return redirect()->route('login.show')->with('authenticationExpired', true);
		}

		return Inertia::render('auth/Login', [
			'message' => session('newPasswordMessage'),
			'authenticationExpired' => session('authenticationExpired')
		]);
    }
}
