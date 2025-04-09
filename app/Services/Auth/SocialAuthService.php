<?php

namespace App\Services\Auth;

use App\Http\Concerns\RefreshesSession;
use App\Http\Requests\Auth\SocialNetworkLoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;

class SocialAuthService
{
	use RefreshesSession;

	public function loginUsingSocialNetwork(SocialNetworkLoginRequest $request, $socialNetwork)
	{
		$socialiteUser = $this->getSocialiteUser($socialNetwork, $request->input('token'));

		if ($socialNetwork == 'facebook') {
			$email = $socialiteUser->user['email'];
		} else if ($socialNetwork == 'google') {
			$email = $socialiteUser->email;
		} else if ($socialNetwork == 'apple') {
			$email = $socialiteUser->email;
		}

		/** @var string $email */
		$user = User::where('email', $email)->first();

		if (!$user) {
			$this->refreshSession($request);
			$user = $this->createUserFromSocialiteUser($socialiteUser, $socialNetwork);
		} else {
			$this->updateUserFromSocialiteUser($socialiteUser, $user, $socialNetwork);
		}

		if ($request->wantsJson()) {
			$user->withAccessToken($user->createToken('AUTH_TOKEN'))->append('plain_text_token');
		} else {
			auth()->guard('web')->login($user);
		}

		return $user;
	}

	protected function updateUserFromSocialiteUser(SocialiteUser $socialiteUser, User $user, $socialNetwork)
	{
		$data = [];

		if ($socialNetwork == 'facebook') {
			$data['facebook_id'] = $socialiteUser->user['id'];
		} else if ($socialNetwork == 'google') {
			$data['google_id'] = $socialiteUser->id;
		} else if ($socialNetwork == 'apple') {
			$data['apple_id'] = $socialiteUser->id;
		}

		if (!$user->hasVerifiedEmail()) {
			$data['email_verified_at'] = now();
		}

		if ($data) {
			$user->update($data);
		}
	}

	protected function createUserFromSocialiteUser(SocialiteUser $socialiteUser, $socialNetwork)
	{
		$data = [
			'email_verified_at' => now(),
			'password' => Hash::make(Str::random(32))
		];

		if ($socialNetwork == 'facebook') {
			$data['email'] = $socialiteUser->user['email'];
			$data['facebook_id'] = $socialiteUser->user['id'];
			// $data['name'] = $socialiteUser->user['first_name'] ?? null;
		} else if ($socialNetwork == 'google') {
			$data['email'] = $socialiteUser->email;
			$data['google_id'] = $socialiteUser->id;
			// $data['name'] = $socialiteUser->user['given_name'] ?? null;
		} else if ($socialNetwork == 'apple') {
			$data['email'] = $socialiteUser->email;
			$data['apple_id'] = $socialiteUser->id;
			// $data['name'] = $socialiteUser->user['name'] ?? null;
		}

		$user = User::forceCreate($data);

		return User::where('email', $user->email)->first();
	}

	protected function getSocialiteUser($socialNetwork, $token): SocialiteUser
	{
		$socialite = Socialite::driver($socialNetwork)->stateless();

		if ($socialNetwork == 'facebook') {
			$socialite = $socialite->fields(['email,first_name']);
		}

		return $socialite->userFromToken($token);
	}
}