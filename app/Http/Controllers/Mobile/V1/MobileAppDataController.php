<?php

namespace App\Http\Controllers\Mobile\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MobileAppDataController extends Controller
{
	public function __invoke(Request $request)
	{
		$data = [];

		return response()->json($data);
	}
}
