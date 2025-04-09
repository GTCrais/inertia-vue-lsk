<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class VerifyEmailRequest extends FormRequest
{
	public ?User $resolvedUser = null;
	public string $requestType;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
		$user = $this->user() ?: User::find($this->route('id'));

		if (!$user) {
			return false;
		}

		$this->resolvedUser = $user;
		$this->requestType = (($this->input('requestType') == 'stateless') ? 'stateless' : 'stateful');

		if (! hash_equals((string) $user->getKey(), (string) $this->route('id'))) {
			return false;
		}

		if (! hash_equals(sha1($user->getEmailForVerification()), (string) $this->route('hash'))) {
			return false;
		}

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
            //
        ];
    }
}
