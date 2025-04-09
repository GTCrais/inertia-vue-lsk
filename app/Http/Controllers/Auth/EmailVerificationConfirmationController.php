<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmailVerificationConfirmationController extends Controller
{
	public function __invoke()
	{
		if (!session()->has('emailVerified')) {
			return redirect('/');
		}

		return Inertia::render('auth/EmailVerified', [
			'requestType' => session('requestType')
		]);
    }
}
