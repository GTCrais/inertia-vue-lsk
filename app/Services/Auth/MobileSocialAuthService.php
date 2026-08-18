<?php

namespace App\Services\Auth;

use App\Http\Concerns\RedirectsToMobileAppWithError;
use App\Http\Requests\Auth\MobileSocialAuthCallbackRequest;
use App\Http\Requests\Auth\MobileSocialAuthExchangeTokenRequest;
use App\Models\Concerns\PreparesMobileAuthData;
use App\Models\User;
use App\Services\MobileDeviceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class MobileSocialAuthService
{
	use PreparesMobileAuthData, RedirectsToMobileAppWithError;

	public function __construct(
		protected SocialAuthService $socialAuthService,
		protected MobileDeviceService $mobileDeviceService
	) {}

	/**
	 * Create state and redirect to social provider's OAuth page.
	 */
	public function redirect(Request $request, string $socialNetwork): RedirectResponse
	{
		$state = Str::random(40);
		$apiVersion = $request->segment(3);

		Cache::put(
			"mobile_social_auth_state:{$state}",
			[
				'social_network' => $socialNetwork,
				'api_version' => $apiVersion,
				'created_at' => now()->timestamp
			],
			now()->addMinutes(5)
		);

		$callbackUrl = url("/api/mobile/{$apiVersion}/social-auth/{$socialNetwork}/oauth/callback");
		$socialite = Socialite::driver($socialNetwork)
			->stateless()
			->redirectUrl($callbackUrl)
			->with(['state' => $state]);

		if ($socialNetwork === 'facebook') {
			$socialite = $socialite->scopes(['email']);
		}

		return $socialite->redirect();
	}

	/**
	 * Handle the callback from the social provider.
	 * Creates a one-time token and redirects to the mobile app.
	 */
	public function callback(MobileSocialAuthCallbackRequest $request, string $socialNetwork): RedirectResponse
	{
		$cacheKey = "mobile_social_auth_state:{$request->input('state')}";
		$state = Cache::get($cacheKey);

		Cache::forget($cacheKey);

		$apiVersion = $state['api_version'] ?? 'x';

		try {
			$callbackUrl = url("/api/mobile/{$apiVersion}/social-auth/{$socialNetwork}/oauth/callback");
			$socialiteUser = Socialite::driver($socialNetwork)
				->stateless()
				->redirectUrl($callbackUrl)
				->user();

			$user = $this->socialAuthService->getUserFromSocialiteUser($request, $socialNetwork, $socialiteUser);
			$oneTimeToken = Str::random(64);

			Cache::put(
				"mobile_social_auth_token:{$oneTimeToken}",
				['user_id' => $user->id, 'created_at' => now()->timestamp],
				now()->addMinutes(5)
			);

			return redirect()->away(config('mobile.uriScheme') . "://auth/social/callback?code={$oneTimeToken}");
		} catch (\Exception $e) {
			report($e);

			return $this->redirectToAppWithError('auth_failed', 'Failed to authenticate with ' . ucfirst($socialNetwork));
		}
	}

	/**
	 * Exchange the one-time token for user data.
	 */
	public function exchangeToken(MobileSocialAuthExchangeTokenRequest $request): array
	{
		$code = $request->input('code');
		$cacheKey = "mobile_social_auth_token:{$code}";
		$tokenData = Cache::get($cacheKey);

		if (!$tokenData) {
			abort(401, 'Invalid or expired token');
		}

		Cache::forget($cacheKey);

		$user = User::findOrFail($tokenData['user_id']);

		$this->mobileDeviceService->markAsLoggedIn($request, $user);

		return $this->getMobileAuthData($request, $user);
	}
}
