<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MobilePushNotificationTokenDestroyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
		return [
			'device_id' => ['required', 'string']
		];
    }

    /**
     * The device id arrives as a header; merge it into the input so it can be validated.
     */
    protected function prepareForValidation(): void
    {
		$this->merge([
			'device_id' => $this->mobileDeviceId()
		]);
    }
}
