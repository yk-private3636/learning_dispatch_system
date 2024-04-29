<?php

namespace App\Http\Requests\Traits;

use Illuminate\Validation\Rules\Password;

trait PasswordRule
{

	public function passwordCombinRule(): Password
	{
		return Password::min(12)->mixedCase()->numbers()->symbols();
	}

	public function passwordCombinMsg(): string
	{
		return __('validate.rules.password');
	}
}