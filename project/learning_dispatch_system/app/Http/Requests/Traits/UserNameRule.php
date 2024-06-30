<?php

namespace App\Http\Requests\Traits;

trait UserNameRule
{
	protected const USER_NAME_DIGITS = 30;
	protected const USER_FULL_NAME_DIGITS = 60;

	public function getUserNameRule(): array
	{
		return [
			'bail',
			'required',
			'string',
			'max:' . self::USER_NAME_DIGITS
		];
	}

	public function getUserFullNameAcceptRule(): array
	{
		return [
			'bail',
			'string',
			'max:' . self::USER_FULL_NAME_DIGITS
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

	public function getUserFullNameMaxMsg(): string
	{
		return __('validate.max', ['digits' => self::USER_FULL_NAME_DIGITS]);
	}
}