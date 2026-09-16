<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class RegistrationPageController extends Controller
{
	public function show()
	{
		return Inertia::render('auth/Registration');
    }
}
