<?php

namespace App\Http\Requests\Auth;

use App\Http\Concerns\RedirectsToMobileAppWithError;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class MobileSocialAuthCallbackRequest extends FormRequest
{
	use RedirectsToMobileAppWithError;

	protected ?array $stateData = null;

	public function authorize(): bool
	{
		return true;
	}

	public function rules(): array
	{
		return [];
	}

	public function withValidator(Validator $validator): void
	{
		$validator->after(function (Validator $validator) {
			if ($this->has('error')) {
				$validator->errors()->add(
					'oauth_error',
					$this->input('error_description', 'Authentication was cancelled or failed')
				);
				return;
			}

			$state = $this->input('state');

			if (!$state || !Cache::has("mobile_social_auth_state:{$state}")) {
				$validator->errors()->add('state', 'Invalid or expired state parameter');
				return;
			}

			$this->stateData = Cache::get("mobile_social_auth_state:{$state}");
		});
	}

	protected function failedValidation(Validator $validator): void
	{
		$errors = $validator->errors();

		if ($errors->has('oauth_error')) {
			$response = $this->redirectToAppWithError(
				$this->input('error'),
				$errors->first('oauth_error')
			);
		} else {
			$response = $this->redirectToAppWithError(
				'invalid_state',
				$errors->first()
			);
		}

		throw new ValidationException($validator, $response);
	}
}
