<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class EmailVerificationConfirmationController extends Controller
{
	public function __invoke(Request $request)
	{
		$token = $request->query('token');

		if ($token && Cache::pull("email_verified:{$token}")) {
			session()->flash('emailVerified');

			return redirect()->route('email-verified.show');
		}

		if (session('emailVerified')) {
			return Inertia::render('auth/EmailVerified');
		}

		return redirect('/');
    }
}
