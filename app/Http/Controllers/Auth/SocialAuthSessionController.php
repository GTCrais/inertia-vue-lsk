<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Concerns\PreparesMobileUser;
use App\Http\Concerns\RefreshesSession;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;

class SocialAuthSessionController extends Controller
{
	use RefreshesSession, PreparesMobileUser;

	public function login(Request $request, $socialNetwork)
	{
		$request->validate([
			'token' => 'required'
		]);

		$socialiteUser = $this->getSocialiteUser($socialNetwork, $request->input('token'));

		if ($socialNetwork == 'facebook') {
			$email = $socialiteUser->user['email'];
		} else if ($socialNetwork == 'google') {
			$email = $socialiteUser->email;
		} else if ($socialNetwork == 'apple') {
			// todo: confirm this works
			$email = $socialiteUser->email;
		}

		/** @var string $email */
		$user = User::where('email', $email)->first();

		if (!$user) {
			$this->refreshSession($request);
			$user = $this->register($socialiteUser, $socialNetwork);
		} else {
			$this->updateUser($socialiteUser, $user, $socialNetwork);
		}

		if ($request->wantsJson()) {
			return response()->json(
				$this->setAccessToken($user)->prepareMobileUser($user)
			);
		}

		auth()->login($user);

		return redirect(Fortify::redirects('login'));
    }

	protected function register(SocialiteUser $socialiteUser, $socialNetwork): User
	{
		$data = [
			'email_verified_at' => now(),
			'role' => UserRole::USER,
			'password' => Hash::make(Str::random(32))
		];

		if ($socialNetwork == 'facebook') {
			$data['email'] = $socialiteUser->user['email'];
			$data['facebook_id'] = $socialiteUser->user['id'];
			$data['name'] = $socialiteUser->user['first_name'] ?? null;
		} else if ($socialNetwork == 'google') {
			$data['email'] = $socialiteUser->email;
			$data['google_id'] = $socialiteUser->id;
			$data['name'] = $socialiteUser->user['given_name'] ?? null;
		} else if ($socialNetwork == 'apple') {
			// todo: confirm this works
			$data['email'] = $socialiteUser->email;
			$data['apple_id'] = $socialiteUser->id;
			$data['name'] = $socialiteUser->user['name'] ?? null;
		}

		$user = User::forceCreate($data);

		return User::where('email', $user->email)->first();
	}

	protected function updateUser(SocialiteUser $socialiteUser, User $user, $socialNetwork)
	{
		$data = [];

		if ($socialNetwork == 'facebook') {
			$data['facebook_id'] = $socialiteUser->user['id'];
		} else if ($socialNetwork == 'google') {
			$data['google_id'] = $socialiteUser->id;
		} else if ($socialNetwork == 'apple') {
			// todo: confirm this works
			$data['apple_id'] = $socialiteUser->id;
		}

		if (!$user->hasVerifiedEmail()) {
			$data['email_verified_at'] = now();
		}

		if ($data) {
			$user->update($data);
		}
	}

	protected function getSocialiteUser($socialNetwork, $token)
	{
		$socialite = Socialite::driver($socialNetwork)->stateless();

		if ($socialNetwork == 'facebook') {
			$socialite = $socialite->fields(['email,first_name']);
		} else if ($socialNetwork == 'apple') {
			// todo: confirm we don't need anything here
		}

		return $socialite->userFromToken($token);
	}
}
