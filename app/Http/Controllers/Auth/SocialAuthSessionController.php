<?php

namespace App\Http\Controllers\Auth;

use App\Http\Concerns\RefreshesSession;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SocialNetworkLoginRequest;
use App\Services\Auth\SocialAuthService;

class SocialAuthSessionController extends Controller
{
	use RefreshesSession;

	public function store(SocialNetworkLoginRequest $request, SocialAuthService $socialAuthService, $socialNetwork)
	{
		$socialAuthService->loginThroughWeb($request, $socialNetwork);

		return redirect()->route('user-account.show');
    }
}
