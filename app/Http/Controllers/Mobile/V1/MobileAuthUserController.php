<?php

namespace App\Http\Controllers\Mobile\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MobileAuthUserController extends Controller
{
	public function __invoke(Request $request)
	{
		return response()->json($request->user());
	}
}
