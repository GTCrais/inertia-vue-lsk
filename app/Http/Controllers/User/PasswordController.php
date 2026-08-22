<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordUpdateRequest;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PasswordController extends Controller
{
	public function __construct(
	    protected ProfileService $profileService
	) {}

	public function show()
	{
		return Inertia::render('user/Password');
    }

	public function update(PasswordUpdateRequest $request)
	{
		$this->profileService->update($request);

		if ($request->wantsJson()) {
			return response()->json();
		}

		return back();
	}
}
