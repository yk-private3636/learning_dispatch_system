<?php

namespace App\Http\Requests\Traits;

trait UserNameRule
{
	private const USER_NAME_DIGITS = 30;

	public function getUserNameRule(): array
	{
		return [
			'bail',
			'required',
			'string',
			'max:' . self::USER_NAME_DIGITS
		];
	}

	public function getUserNameRequiredMsg(): string
	{
		return __('validate.required');
	}

	public function getUserNameStringMsg(): string
	{
		return __('validate.string');
	}

	public function getUserNameMaxMsg(): string
	{
		return __('validate.max', ['digits' => self::USER_NAME_DIGITS]);
	}
}