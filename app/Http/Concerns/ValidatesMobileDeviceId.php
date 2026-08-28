<?php

namespace App\Http\Concerns;

use Illuminate\Contracts\Validation\Validator;

trait ValidatesMobileDeviceId
{
	public function withValidator(Validator $validator): void
	{
		$validator->after(function (Validator $validator) {
			if (!$this->mobileApp()) {
				return;
			}

			$deviceId = $this->mobileDeviceId();

			if (!is_string($deviceId) || $deviceId === '' || strlen($deviceId) > 255) {
				$validator->errors()->add('device_id', 'A valid device id header is required.');
			}
		});
	}
}
