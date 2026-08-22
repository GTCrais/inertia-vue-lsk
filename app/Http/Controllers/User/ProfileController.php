<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
	public function __construct(
	    protected ProfileService $profileService
	) {}

	public function show(Request $request)
	{
		return Inertia::render('user/Profile');
    }

	public function update(ProfileUpdateRequest $request)
	{
		$this->profileService->update($request);

		if ($request->wantsJson()) {
			return UserResource::make($request->user());
		}

		return back();
	}
}
