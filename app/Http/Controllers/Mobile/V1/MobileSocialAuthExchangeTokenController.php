<?php

namespace App\Http\Controllers\Mobile\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\MobileSocialAuthExchangeTokenRequest;
use App\Services\Auth\MobileSocialAuthService;
use Illuminate\Http\JsonResponse;

class MobileSocialAuthExchangeTokenController extends Controller
{
	public function __construct(
		protected MobileSocialAuthService $mobileSocialAuthService
	) {}

	public function __invoke(MobileSocialAuthExchangeTokenRequest $request): JsonResponse
	{
		return response()->json($this->mobileSocialAuthService->exchangeToken($request));
	}
}
