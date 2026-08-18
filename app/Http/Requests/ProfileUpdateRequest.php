<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Intervention\Image\Laravel\Facades\Image;
use Ramsey\Uuid\Uuid;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

	public function prepareForValidation()
	{
		if ($this->input('avatar_remove') === 'true') {
			$this->merge([
				'avatar_remove' => true
			]);
		}

		if ($this->input('avatar_remove') !== true) {
			$this->merge([
				'avatar_remove' => false
			]);
		}

		if ($this->input('avatar_remove') === true) {
			$this->merge([
				'avatar' => null
			]);
		} else if ($file = $this->file('avatar_file')) {
			$this->merge([
				'avatar' => Uuid::uuid4()->toString() . '.' . $file->getClientOriginalExtension()
			]);
		} else if ($this->input('avatar_base64')) {
			$this->merge([
				'avatar' => Uuid::uuid4()->toString() . '.jpg'
			]);
		}
	}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $data = [
			'avatar_file' => ['nullable', 'image', 'max:20480'],
			'avatar_base64' => ['nullable', 'string', function ($attribute, $value, $fail) {
				try {
					Image::read($value);
				} catch (\Exception) {
					$fail('The avatar must be a valid image.');
				}
			}],
			'avatar_remove' => ['boolean'],
			'avatar' => ['sometimes', 'nullable', 'string']
        ];

		return $data;
    }
}
