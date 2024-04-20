<?php

namespace App\Http\Requests\Traits;

use Illuminate\Validation\Rules\Password;

trait PasswordRule
{
	public function getRuleOrMsg(string $switch): array
	{
		return match ($switch) {
			\KeyConst::GET_VALID_RULE => [
				Password::min(12)->mixedCase()->numbers()->symbols()	
			],
			\KeyConst::GET_VALID_MSG => [
            	'password.Illuminate\Validation\Rules\Password' => __('validate.rules.password')
			]
		};
	}

}