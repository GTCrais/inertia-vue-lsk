<?php

namespace App\Services;

use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ProfileService
{
	public function update(ProfileUpdateRequest|PasswordUpdateRequest $request)
	{
		DB::transaction(function () use ($request) {
			$data = $request->validated();

			if ($data['password'] ?? null) {
				$data['password'] = Hash::make($data['password']);
			}

			$previousAvatar = $request->user()->avatar;
			$deletePreviousAvatar = false;

			$request->user()->update($data);
			$request->user()->refresh();

			if ($avatarSource = ($data['avatar_file'] ?? $data['avatar_base64'] ?? null)) {
				$encoded = Image::decode($avatarSource)->cover(300, 300)->encode();

				Storage::put('avatars/' . $data['avatar'], $encoded);

				$deletePreviousAvatar = true;
			} else if ($data['avatar_remove'] ?? null) {
				$deletePreviousAvatar = true;
			}

			if ($deletePreviousAvatar) {
				$this->optionallyDeleteAvatar($previousAvatar);
			}
		});
	}

	public function optionallyDeleteAvatar($filename)
	{
		if ($filename && Storage::exists('avatars/' . $filename)) {
			Storage::delete('avatars/' . $filename);
		}
	}
}
