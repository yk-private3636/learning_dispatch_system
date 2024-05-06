<?php

namespace App\Http\Requests\Traits;

use Illuminate\Validation\Rules\Password;

trait PasswordRule
{

	public function getPasswordRule(): array
	{
		return [
			'bail',
			'required',
			Password::min(12)->mixedCase()->numbers()->symbols()
		];
	}

	public function getConfirmPasswordRule(string $sameKey = 'password'): array
	{
		return [
			'bail',
			'required',
			"same:{$sameKey}"
		];
	}

	public function passwordRequiredMsg(): string
	{
		return __('validate.required');
	}

	public function passwordCombinMsg(): string
	{
		return __('validate.password.combin');
	}

	public function confirmPasswordRequiredMsg(): string
	{
		return __('validate.required');
	}
	
	public function confirmPasswordSameMsg(string $attribute = 'パスワード'): string
	{
		return __('validate.same', ['attribute' => $attribute]);
	}
}