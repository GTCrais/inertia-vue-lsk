<?php

namespace App\Services;

use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Laravel\Facades\Image;

class ProfileService
{
	public function update(ProfileUpdateRequest|PasswordUpdateRequest $request)
	{
		try {
		    \DB::beginTransaction();

			$data = $request->validated();

			if ($data['password'] ?? null) {
				$data['password'] = \Hash::make($data['password']);
			}

			$previousAvatar = $request->user()->avatar;
			$deletePreviousAvatar = false;

			$request->user()->update($data);
			$request->user()->refresh();

			/** @var UploadedFile $avatarFile */
			if ($avatarFile = ($data['avatar_file'] ?? null)) {
				$encoded = Image::read($avatarFile)->cover(300, 300)->encode();

				\Storage::put('avatars/' . $data['avatar'], $encoded);

				$deletePreviousAvatar = true;
			}  else if ($avatarBase64 = ($data['avatar_base64'] ?? null)) {
				$encoded = Image::read($avatarBase64)->cover(300, 300)->encode();

				\Storage::put('avatars/' . $data['avatar'], $encoded);

				$deletePreviousAvatar = true;
			} else if ($data['avatar_remove'] ?? null) {
				$deletePreviousAvatar = true;
			}

			if ($deletePreviousAvatar) {
				$this->optionallyDeleteAvatar($previousAvatar);
			}

		    \DB::commit();
		} catch (\Throwable $e) {
		    \DB::rollBack();
		    throw $e;
		}
	}

	public function optionallyDeleteAvatar($filename)
	{
		if ($filename && \Storage::exists('avatars/' . $filename)) {
			\Storage::delete('avatars/' . $filename);
		}
	}
}