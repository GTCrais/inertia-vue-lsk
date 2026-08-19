<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class LoginPageController extends Controller
{
	public function show()
	{
		return Inertia::render('auth/Login', [
			'message' => session('newPasswordMessage')
		]);
    }
}
