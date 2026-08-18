<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EmailVerificationNotificationController extends Controller
{
    public function store(Request $request)
    {
        if (!$request->user()->hasVerifiedEmail()) {
        	$request->user()->sendEmailVerificationNotification();
        }

		if ($request->wantsJson()) {
			return response()->json();
		}

		return back();
    }
}
